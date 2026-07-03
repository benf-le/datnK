<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showOrder($id)
    {
        $order = Order::with(['orderItems.product', 'user', 'payment'])->findOrFail($id);

        $userId = auth()->id();
        return view('clients.pages.order-detail', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->where('status', 'pending')
        ->firstOrFail();

        foreach($order->orderItems as $item)
        {
            $item->product->increment('stock', $item->quantity);
        }

        //Update order status cancel
        $order->update(['status' => 'canceled']);
        return redirect()->back()->with('success', 'Đơn hàng của bạn đã được hủy thành công.');
    }

    public function received($id)
    {
        $order = Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->where('status', 'processing')
        ->firstOrFail();

        //Update order status completed
        $order->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Nhận hàng thành công. Bạn có thể đánh giá đơn hàng này!');
    }
}
