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

            toastr()->success('Đặt hàng thành công.');
            return redirect()->route('account');
        } catch (\Exception $e) {
            toastr()->error('Có lỗi xảy ra, vui lòng thử lại.');
            return redirect()->route('checkout');
        }
    }

    public function placeOrderPayPal(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $cartItems = CartItem::where('user_id', $user->id)->get();
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
            $order->total_price = $request->amount * 25000;
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
                'payment_method' => 'paypal',
                'transaction_id' => $request->transactionID,
                'amount' => $order->total_price,
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            //Delete product in cart when order
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            toastr()->error('Có lỗi xảy ra, vui lòng thử lại.');
            return redirect()->route('checkout');
        }
    }
}
