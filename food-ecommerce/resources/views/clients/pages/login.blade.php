@extends('layouts.client')

@section('title', 'Đăng nhập')
@section('breadcrumb', 'Đăng nhập')

@section('content')

<style>
    /* Modern Premium Login CSS */
    .premium-login-area {
        position: relative;
        padding: 80px 0;
        background: linear-gradient(135deg, #f3f9f5 0%, #e8f5e9 100%);
        overflow: hidden;
    }
    
    /* Decorative blobs */
    .premium-login-area::before,
    .premium-login-area::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.6;
        animation: float 8s ease-in-out infinite alternate;
    }
    .premium-login-area::before {
        width: 400px;
        height: 400px;
        background: rgba(142, 204, 160, 0.4);
        top: -100px;
        left: -100px;
    }
    .premium-login-area::after {
        width: 300px;
        height: 300px;
        background: rgba(255, 204, 128, 0.4);
        bottom: -50px;
        right: -50px;
        animation-delay: -4s;
    }

    @keyframes float {
        0% { transform: translateY(0px) scale(1); }
        100% { transform: translateY(40px) scale(1.1); }
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
        position: relative;
        z-index: 1;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.08);
    }

    .premium-title {
        font-family: 'Outfit', 'Inter', sans-serif;
        font-weight: 800;
        font-size: 2.5rem;
        color: #1a1a1a;
        margin-bottom: 15px;
        background: linear-gradient(90deg, #2e7d32, #4caf50);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .premium-subtitle {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    /* Custom Inputs */
    .modern-input-group {
        margin-bottom: 25px;
        position: relative;
    }
    
    .modern-input {
        width: 100%;
        padding: 16px 20px;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        background: #fafafa;
        font-size: 16px;
        transition: all 0.3s ease;
        outline: none;
    }
    
    .modern-input:focus {
        border-color: #4caf50;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
    }

    /* Buttons */
    .btn-gradient {
        background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
        color: #fff !important;
        border: none;
        border-radius: 12px;
        padding: 16px 30px;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.5px;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(76, 175, 80, 0.2);
        cursor: pointer;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(76, 175, 80, 0.3);
        background: linear-gradient(135deg, #43a047 0%, #1b5e20 100%);
    }

    .btn-outline-dark {
        background: transparent;
        color: #333 !important;
        border: 2px solid #333;
        border-radius: 12px;
        padding: 16px 30px;
        font-size: 16px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-block;
        margin-top: 15px;
    }
    
    .btn-outline-dark:hover {
        background: #333;
        color: #fff !important;
        transform: translateY(-2px);
    }

    .forgot-pass-link {
        color: #2e7d32;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: color 0.3s ease;
        display: inline-block;
        margin-top: 15px;
    }
    
    .forgot-pass-link:hover {
        color: #1b5e20;
        text-decoration: underline;
    }

    /* Alerts */
    .modern-alert {
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 14px;
        border: none;
        background: #ffebee;
        color: #c62828;
        margin-top: -15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>

<div class="premium-login-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-4 align-items-stretch">
                    <!-- Login Form -->
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="glass-card">
                            <h2 class="premium-title">Đăng Nhập</h2>
                            <p class="premium-subtitle">Chào mừng trở lại! Hãy đăng nhập để mua sắm những sản phẩm tươi ngon nhất.</p>
                            
                            <form action="#" method="POST" id="login-form">
                                @csrf

                                <div class="modern-input-group">
                                    <input type="email" name="email" class="modern-input" placeholder="Địa chỉ Email" required value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <div class="modern-alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror

                                <div class="modern-input-group">
                                    <input type="password" name="password" class="modern-input" placeholder="Mật khẩu" required>
                                </div>
                                @error('password')
                                    <div class="modern-alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror

                                <button class="btn-gradient" type="submit">ĐĂNG NHẬP NGAY</button>
                                
                                <div class="text-center mt-3">
                                    <a href="{{ route('password.request') }}" class="forgot-pass-link">Bạn quên mật khẩu?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Register CTA -->
                    <div class="col-md-6">
                        <div class="glass-card d-flex flex-column justify-content-center text-center" style="background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7));">
                            <div class="mb-4">
                                <i class="fas fa-user-plus" style="font-size: 3rem; color: #4caf50; margin-bottom: 20px;"></i>
                                <h3 style="font-weight: 800; color: #1a1a1a; font-size: 1.8rem; margin-bottom: 15px;">Chưa Có Tài Khoản?</h3>
                                <p style="color: #555; font-size: 1.05rem; line-height: 1.6; margin-bottom: 30px;">
                                    Đăng ký thành viên ngay để tận hưởng nhiều đặc quyền:<br>
                                    <span style="display: inline-block; text-align: left; margin-top: 15px;">
                                        ✅ Lưu sản phẩm yêu thích<br>
                                        ✅ Nhận ưu đãi độc quyền<br>
                                        ✅ Theo dõi đơn hàng dễ dàng
                                    </span>
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('register') }}" class="btn-outline-dark">TẠO TÀI KHOẢN MỚI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection