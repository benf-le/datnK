<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('is_read', 0)->latest('created_at')->get();

        foreach ($notifications as $noti) {
            if($noti->type === 'order') $noti->title = "Có đơn hàng mới";
            else if($noti->type === 'contact') $noti->title = "Có liên hệ mới";
            else if ($noti->type === 'wishlist') $noti->title = "Có yêu thích mới";
        }

        return view('admin.pages.notifications', compact('notifications'));
    }

    public function update(Request $request)
    {
        Notification::where('id', $request->id)->update(['is_read' => 1]);

        return response()->json(['status' => true]);

    }
}
