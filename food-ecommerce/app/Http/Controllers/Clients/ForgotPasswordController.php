<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('clients.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ email.',
                'email.email' => 'Email không hợp lệ.',
                'email.exist' => 'Email không tồn tại trêm hệ thống'
            ]
        );

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT)
        {
            toastr()->success('Liên kết đặt lại mật khẩu đã được gửi đến email của bạn');
            return back();
        }

        toastr()->error('Không thể gửi email đặt lại mật khẩu');
        return back()->withErrors(['email' => __($status)]);
    }
}
