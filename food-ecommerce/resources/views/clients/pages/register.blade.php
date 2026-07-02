@extends('layouts.client')

@section('title', 'Đăng kí')
@section('breadcrumb', 'Đăng kí')

@section('content')
    <div class="ltn__login-area pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area text-center">
                        <h1 class="section-title">Đăng Kí <br>Tài Khoản Của Bạn</h1>
                        <p>Tham gia cùng KFood để trải nghiệm mua sắm thực phẩm sạch, tươi ngon mỗi ngày.<br>
                            Nhanh chóng – An toàn – Tiện lợi.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="account-login-inner">
                        <form action="{{ route('post-register') }}" class="ltn__form-box contact-form-box" method="POST" id="register-form">
                            @csrf

                            <input type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="text" name="email" placeholder="Email*" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="password" name="password" placeholder="Mật khẩu*" required>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="password" name="confirmPassword" placeholder="Xác nhận mật khẩu*" required>
                            @error('confirmPassword')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <label class="checkbox-inline">
                                <input type="checkbox" name="checkbox1" value="" required>
                                Tôi đồng ý để KFood sử dụng thông tin của tôi nhằm gửi ưu đãi và tin tức phù hợp với sở thích cá nhân.
                            </label>
                            @error('checkbox1')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <label class="checkbox-inline">
                                <input type="checkbox" name="checkbox2" value="" required>
                                Khi nhấn “Tạo tài khoản”, tôi đồng ý với chính sách bảo mật của KFood.
                            </label>
                            @error('checkbox2')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="btn-wrapper">
                                <button class="theme-btn-1 btn reverse-color btn-block" type="submit">TẠO TÀI KHOẢN</button>
                            </div>
                        </form>
                        <div class="by-agree text-center">
                            <p>Bằng cách tạo tài khoản, bạn đồng ý với:</p>
                            <p><a href="#">ĐIỀU KHOẢN SỬ DỤNG &nbsp; &nbsp; | &nbsp; &nbsp; CHÍNH SÁCH BẢO MẬT</a></p>
                            <div class="go-to-btn mt-50">
                                <a href="{{ route('login') }}">ĐÃ CÓ TÀI KHOẢN ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection