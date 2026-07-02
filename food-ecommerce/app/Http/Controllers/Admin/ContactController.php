<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('is_replied')
        ->orderByDesc('created_at')->get();

        return view('admin.pages.contact', compact('contacts'));
    }

    public function replyContact(Request $request)
    {
        $cid = $request->id;
        $email = $request->email;
        $messageContent = $request->message;
        if(is_object($messageContent)){
            $messageContent = (string)$messageContent;
        }

        try {

           Mail::send('admin.emails.reply-contact', compact('messageContent'), function ($message) use ($email) {
               $message->to($email)->subject('KFood phản hồi liên hệ của khách hàng');
           });

           Contact::where('id', $cid)->update(['is_replied' => 1]);

           return response()->json([
                'status' => true, 
                'message' => 'Phản hồi đã được gửi thành công.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
            'status' => false, 
            'message' => 'Không thể gửi phản hồi qua email. Vui lòng thử lại sau.' . $th->getMessage()
        ], 404);
        }
    }
}
