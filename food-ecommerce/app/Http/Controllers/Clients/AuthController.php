<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Mail\ActivationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('clients.pages.register');
    }

    public function register(Request $request)
    {
        //Validate backend
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.unique' => 'Địa chỉ email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        //Check if email exists
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            if ($existingUser->isPending()) {
                toastr() . error('Email đã được đăng kí và đang đợi kích hoạt');
                return redirect()->route('register');
            }
            return redirect()->route('register');
        }

        //Create token active
        $token = Str::random(64);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
            'role_id' => 3,
            'activation_token' => $token,
        ]);

        Mail::to($user->email)->send(new ActivationMail($token, $user));

        toastr()->success('Đăng kí tài khoản thành công. Vui lòng kiểm tra email để kích hoạt tài khoản');
        return redirect()->route('login');
    }

    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if ($user) {
            $user->status = 'active';
            $user->activation_token = null;
            $user->save();

            toastr()->success('Kích hoạt tài khoản thành công');
            return redirect()->route('login');
        }

        toastr()->error('Token không hợp lệ hoặc đã hết hạn');
        return redirect()->back();
    }

    public function showloginForm()
    {
        return view('clients.pages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        //Check login information
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {
            if (in_array(Auth::user()->role->name, ['customer'])) {
                $request->session()->regenerate();
                toastr()->success('Đăng nhập thành công');

                return redirect()->route('home');
            } else {
                Auth::logout();
                toastr()->warning('Bạn không có quyền truy cập vào tài khoản này');
                return redirect()->back();
            }
        }

        toastr()->error('Thông tin đăng nhập không chính xác hoặc tài khoản chưa kích hoạt.');
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('Đăng xuất thành công');
        return redirect()->route('login');
    }
}
