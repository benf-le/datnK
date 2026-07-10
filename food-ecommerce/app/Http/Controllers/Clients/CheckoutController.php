<?php

namespace App\Http\Controllers\Clients;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = ShippingAddress::where('user_id', $user->id)->get();
        $defaultAddress = $addresses->where('is_default', 1)->first();
        if (is_null($addresses) || is_null($defaultAddress)) {
            toastr()->error('Vui lòng thêm địa chỉ giao hàng.');
            return redirect()->route('account');
        }

        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
        $totalPrice = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        return view('clients.pages.checkout', compact('addresses', 'defaultAddress', 'cartItems', 'totalPrice'));
    }

    public function getAddress(Request $request)
    {
        $address = ShippingAddress::where('id', $request->address_id)
            ->where('user_id', Auth::id())->first();

        if (!$address) {
            return response()->json(['success' => false, 'message' => 'Không tim thấy địa chỉ.']);
        }

        return response()->json([
            'success' => true,
            'data' => $address
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống.');
        }
        DB::beginTransaction();

        try {
            //Fetch address details
            $address = ShippingAddress::where('id', $request->address_id)->where('user_id', $user->id)->firstOrFail();

            //Create order
            $order = new Order();
            $order->user_id = $user->id;
            $order->shipping_full_name = $address->full_name;
            $order->shipping_phone = $address->phone;
            $order->shipping_address = $address->address;
            $order->shipping_ward = $address->ward;
            $order->shipping_district = $address->district;
            $order->shipping_city = $address->city;
            $order->total_price = $cartItems->sum(fn($item) => $item->quantity * $item->product->price) + 25000;
            $order->status = 'pending'; //default is pending
            $order->save();

            foreach ($cartItems  as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);

                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Sản phẩm {$product->name} không đủ hàng trong kho");
                }
                $product->stock -= $item->quantity;
                $product->save();
            }

            //Create payment
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $order->total_price,
                'status' => 'pending',
                'paid_at' => null,
            ]);

            //Delete product in cart when order
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            Notification::create([
                'user_id' => $user->id,
                'type' => 'order',
                'message' => "Có đơn đặt hàng mới từ " . $user->email,
                'link' => '/orders',
                'is_read' => 0
            ]);

            if ($request->payment_method === 'payos') {
                try {
                    $payOS = new \PayOS\PayOS(
                        config('payos.client_id'),
                        config('payos.api_key'),
                        config('payos.checksum_key')
                    );

                    $payosItems = [];
                    foreach ($order->orderItems as $item) {
                        $payosItems[] = [
                            'name' => substr($item->product_name, 0, 50),
                            'quantity' => intval($item->quantity),
                            'price' => intval($item->price)
                        ];
                    }
                    $payosItems[] = [
                        'name' => 'Phí vận chuyển',
                        'quantity' => 1,
                        'price' => 25000
                    ];

                    $description = 'Thanh toan don #' . $order->id;
                    if (strlen($description) > 25) {
                        $description = substr($description, 0, 25);
                    }

                    $paymentData = [
                        'orderCode' => intval($order->id),
                        'amount' => intval($order->total_price),
                        'description' => $description,
                        'items' => $payosItems,
                        'returnUrl' => route('checkout.payos.success'),
                        'cancelUrl' => route('checkout.payos.cancel'),
                    ];

                    $response = $payOS->paymentRequests->create($paymentData);
                    return redirect()->away($response->checkoutUrl);
                } catch (\Exception $e) {
                    Log::error('PayOS error on initial redirect: ' . $e->getMessage());
                    toastr()->warning('Đơn hàng đã được đặt. Không thể mở trang thanh toán PayOS lúc này, quý khách vui lòng thanh toán lại trong mục chi tiết đơn hàng.');
                    return redirect()->route('account');
                }
            }

            toastr()->success('Đặt hàng thành công.');
            return redirect()->route('account');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Có lỗi xảy ra, vui lòng thử lại.');
            return redirect()->route('checkout');
        }
    }


    public function payosSuccess(Request $request)
    {
        $orderCode = $request->query('orderCode');
        $status = $request->query('status');

        $order = Order::with('payment')->findOrFail($orderCode);

        try {
            $payOS = new \PayOS\PayOS(
                config('payos.client_id'),
                config('payos.api_key'),
                config('payos.checksum_key')
            );
            $paymentLinkInfo = $payOS->paymentRequests->get($orderCode);

            if ($paymentLinkInfo->status === 'PAID') {
                DB::transaction(function () use ($order, $paymentLinkInfo) {
                    $order->update(['status' => 'processing']);
                    if ($order->payment) {
                        $order->payment->update([
                            'status' => 'completed',
                            'transaction_id' => $paymentLinkInfo->id,
                            'paid_at' => now(),
                        ]);
                    }
                });
                toastr()->success('Thanh toán đơn hàng thành công!');
            } else {
                toastr()->warning('Đơn hàng chưa được thanh toán thành công.');
            }
        } catch (\Exception $e) {
            Log::error('PayOS Success query error: ' . $e->getMessage());
            if ($status === 'PAID') {
                DB::transaction(function () use ($order) {
                    $order->update(['status' => 'processing']);
                    if ($order->payment) {
                        $order->payment->update([
                            'status' => 'completed',
                            'paid_at' => now(),
                        ]);
                    }
                });
                toastr()->success('Thanh toán đơn hàng thành công!');
            } else {
                toastr()->error('Không thể xác nhận trạng thái thanh toán từ PayOS.');
            }
        }

        return redirect()->route('account');
    }

    public function payosCancel(Request $request)
    {
        $orderCode = $request->query('orderCode');
        $order = Order::find($orderCode);
        if ($order) {
            toastr()->info('Thanh toán đã bị hủy. Bạn có thể thanh toán lại trong phần chi tiết đơn hàng.');
        } else {
            toastr()->error('Không tìm thấy đơn hàng.');
        }
        return redirect()->route('account');
    }

    public function payosPayAgain($id)
    {
        $user = Auth::user();
        $order = Order::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        if ($order->status !== 'pending') {
            toastr()->error('Đơn hàng này không ở trạng thái chờ thanh toán.');
            return redirect()->route('account');
        }

        $payment = $order->payment;
        if (!$payment || $payment->status === 'completed') {
            toastr()->error('Đơn hàng này đã được thanh toán.');
            return redirect()->route('account');
        }

        $payOS = new \PayOS\PayOS(
            config('payos.client_id'),
            config('payos.api_key'),
            config('payos.checksum_key')
        );

        $payosItems = [];
        foreach ($order->orderItems as $item) {
            $payosItems[] = [
                'name' => substr($item->product_name, 0, 50),
                'quantity' => intval($item->quantity),
                'price' => intval($item->price)
            ];
        }
        $payosItems[] = [
            'name' => 'Phí vận chuyển',
            'quantity' => 1,
            'price' => 25000
        ];

        $description = 'Thanh toan don #' . $order->id;
        if (strlen($description) > 25) {
            $description = substr($description, 0, 25);
        }

        $paymentData = [
            'orderCode' => intval($order->id),
            'amount' => intval($order->total_price),
            'description' => $description,
            'items' => $payosItems,
            'returnUrl' => route('checkout.payos.success'),
            'cancelUrl' => route('checkout.payos.cancel'),
        ];

        try {
            try {
                $payOS->paymentRequests->cancel($order->id, 'Khach hang thanh toan lai');
            } catch (\Exception $cancelEx) {
                // Ignore if it was not created or already cancelled/expired
            }

            $response = $payOS->paymentRequests->create($paymentData);
            return redirect()->away($response->checkoutUrl);
        } catch (\Exception $e) {
            Log::error('PayOS pay again error: ' . $e->getMessage());
            toastr()->error('Không thể kết nối tới cổng thanh toán PayOS. Vui lòng thử lại sau.');
            return redirect()->route('account');
        }
    }

    public function payosWebhook(Request $request)
    {
        try {
            $payOS = new \PayOS\PayOS(
                config('payos.client_id'),
                config('payos.api_key'),
                config('payos.checksum_key')
            );

            $webhookPayload = $request->all();
            $verifiedData = $payOS->webhooks->verify($webhookPayload);

            if ($verifiedData && $verifiedData->code === '00') {
                $orderCode = $verifiedData->orderCode;
                $order = Order::with('payment')->find($orderCode);

                if ($order && $order->status === 'pending') {
                    DB::transaction(function () use ($order, $verifiedData) {
                        $order->update(['status' => 'processing']);
                        if ($order->payment) {
                            $order->payment->update([
                                'status' => 'completed',
                                'transaction_id' => $verifiedData->reference,
                                'paid_at' => now(),
                            ]);
                        }
                    });
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('PayOS webhook error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}

