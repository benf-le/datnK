<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems', 'user', 'payment')->latest()->get();

        return view('admin.pages.orders', compact('orders'));
    }

    public function confirmOrder(Request $request)
    {
        $order = Order::find($request->id);

        if ($order) {
            $order->status = 'processing';
            $order->save();

            return response()->json([
                'status' => true, 
                'message' => 'Đơn hàng đã được xác nhận thành công.'
            ]);
        }

        return response()->json([
            'status' => false, 
            'message' => 'Đơn hàng không tồn tại.'
        ], 404);
    }

    public function showOrderDetail($id)
    {
        $order = Order::with('orderItems.product', 'user', 'payment')->find($id);

        return view('admin.pages.order-detail', compact(var_name: 'order'));
    }

    public function sendMailInvoice(Request $request)
    {
        $id = $request->id;
        $order = Order::with('orderItems.product', 'user', 'payment')->find($id);

        try {

           Mail::send('admin.emails.invoice', compact('order'), function ($message) use ($order) {
               $message->to($order->user->email)->subject('Hóa đơn mua hàng từ KFood của khách hàng: ' . $order->shippingAddress->full_name);
           });

           return response()->json([
                'status' => true, 
                'message' => 'Hóa đơn đã được gửi thành công.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
            'status' => false, 
            'message' => 'Không thể gửi hóa đơn qua email. Vui lòng thử lại sau.' . $th->getMessage()
        ], 404);
        }
    }

    public function cancelOrder(Request $request)
    {
        $id = $request->id;
        $order = Order::find($id);

        if ($order) {

            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            
            $order->status = 'canceled';
            $order->save();

            return response()->json([
                'status' => true, 
                'message' => 'Đơn hàng đã được hủy thành công.'
            ]);
        }

        return response()->json([
            'status' => false, 
            'message' => 'Đơn hàng không tồn tại.'
        ], 404);
    }
}
