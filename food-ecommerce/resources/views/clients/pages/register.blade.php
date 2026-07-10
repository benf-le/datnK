@extends('layouts.client')

@section('title', 'Đăng ký')
@section('breadcrumb', 'Đăng ký')

@section('content')

<style>
    /* Modern Premium Register CSS */
    .premium-register-area {
        position: relative;
        padding: 80px 0;
        background: linear-gradient(135deg, #f3f9f5 0%, #e8f5e9 100%);
        overflow: hidden;
    }
    
    /* Decorative blobs */
    .premium-register-area::before,
    .premium-register-area::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.6;
        animation: float 8s ease-in-out infinite alternate;
    }
    .premium-register-area::before {
        width: 400px;
        height: 400px;
        background: rgba(142, 204, 160, 0.4);
        top: -100px;
        left: -100px;
    }
    .premium-register-area::after {
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
        font-family: var(--ltn__body-font);
        font-weight: 600;
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

    /* Custom Checkbox Design */
    .modern-checkbox-container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 18px;
        cursor: pointer;
        font-size: 14px;
        line-height: 1.5;
        color: #555;
        user-select: none;
    }

    .modern-checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 3px;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: #eee;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: 2px solid #ddd;
    }

    .modern-checkbox-container:hover input ~ .checkmark {
        background-color: #e0e0e0;
        border-color: #bbb;
    }

    .modern-checkbox-container input:checked ~ .checkmark {
        background-color: #4caf50;
        border-color: #4caf50;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .modern-checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }

    .modern-checkbox-container .checkmark:after {
        left: 7px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 2.5px 2.5px 0;
        transform: rotate(45deg);
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
    
    .btn-gradient:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(76, 175, 80, 0.3);
        background: linear-gradient(135deg, #43a047 0%, #1b5e20 100%);
    }

    .btn-gradient:disabled {
        background: #ccc !important;
        color: #888 !important;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
        opacity: 0.7;
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

<div class="premium-register-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-4 align-items-stretch">
                    <!-- Register Form -->
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="glass-card">
                            <h2 class="premium-title">Đăng Ký</h2>
                            <p class="premium-subtitle">Tham gia KFood ngay để trải nghiệm mua sắm thực phẩm sạch, tươi ngon mỗi ngày.</p>
                            
                            <form action="{{ route('post-register') }}" method="POST" id="register-form">
                                @csrf

                                <div class="modern-input-group">
                                    <input type="text" name="name" class="modern-input" placeholder="Họ và tên" value="{{ old('name') }}" required autocomplete="name">
                                </div>
                                @error('name')
                                    <div class="modern-alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror

                                <div class="modern-input-group">
                                    <input type="email" name="email" class="modern-input" placeholder="Địa chỉ Email*" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                                @error('email')
                                    <div class="modern-alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror

                                <div class="modern-input-group">
                                    <input type="password" name="password" class="modern-input" placeholder="Mật khẩu*" required autocomplete="new-password">
                                </div>
                                @error('password')
                                    <div class="modern-alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror

                                <div class="modern-input-group">
                                    <input type="password" name="confirmPassword" class="modern-input" placeholder="Xác nhận mật khẩu*" required autocomplete="new-password">
                                </div>
                                @error('confirmPassword')
                                    <div class="modern-alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror

                                <div class="mb-4">
                                    <label class="modern-checkbox-container">
                                        Tôi đồng ý để KFood sử dụng thông tin của tôi nhằm gửi ưu đãi và tin tức phù hợp với sở thích cá nhân.
                                        <input type="checkbox" name="checkbox1" id="checkbox1" required>
                                        <span class="checkmark"></span>
                                    </label>
                                    @error('checkbox1')
                                        <div class="modern-alert" style="margin-top: 5px; margin-bottom: 10px;">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror

                                    <label class="modern-checkbox-container">
                                        Khi nhấn “Tạo tài khoản”, tôi đồng ý với chính sách bảo mật của KFood.
                                        <input type="checkbox" name="checkbox2" id="checkbox2" required>
                                        <span class="checkmark"></span>
                                    </label>
                                    @error('checkbox2')
                                        <div class="modern-alert" style="margin-top: 5px; margin-bottom: 10px;">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button class="btn-gradient" type="submit" id="register-submit-btn" disabled>ĐĂNG KÝ NGAY</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Login CTA -->
                    <div class="col-md-6">
                        <div class="glass-card d-flex flex-column justify-content-center text-center" style="background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7));">
                            <div class="mb-4">
                                <i class="fas fa-sign-in-alt" style="font-size: 3rem; color: #4caf50; margin-bottom: 20px;"></i>
                                <h3 style="font-family: var(--ltn__body-font); font-weight: 600; color: #1a1a1a; font-size: 1.8rem; margin-bottom: 15px;">Đã Có Tài Khoản?</h3>
                                <p style="color: #555; font-size: 1.05rem; line-height: 1.6; margin-bottom: 30px;">
                                    Đăng nhập ngay để tiếp tục mua sắm những thực phẩm tươi sạch hàng đầu và nhận được các chương trình khuyến mãi độc quyền dành riêng cho bạn.
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('login') }}" class="btn-outline-dark">ĐĂNG NHẬP NGAY</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox1 = document.getElementById('checkbox1');
        const checkbox2 = document.getElementById('checkbox2');
        const registerBtn = document.getElementById('register-submit-btn');
        const registerForm = document.getElementById('register-form');

        function toggleRegisterButton() {
            if (checkbox1.checked && checkbox2.checked) {
                registerBtn.disabled = false;
            } else {
                registerBtn.disabled = true;
            }
        }

        if (checkbox1 && checkbox2 && registerBtn) {
            checkbox1.addEventListener('change', toggleRegisterButton);
            checkbox2.addEventListener('change', toggleRegisterButton);
            
            // Run on load in case the browser caches the checked state on reload
            toggleRegisterButton();
        }

        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                if (!checkbox1.checked || !checkbox2.checked) {
                    e.preventDefault();
                    alert('Vui lòng đồng ý với tất cả điều khoản trước khi đăng ký.');
                }
            });
        }
    });
</script>
@endsection