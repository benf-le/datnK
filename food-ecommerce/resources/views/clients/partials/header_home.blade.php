<!-- HEADER AREA START (header-5) -->
<header class="ltn__header-area ltn__header-5 ltn__header-transparent-- gradient-color-4---">
    <!-- ltn__header-top-area start -->
    <div class="ltn__header-top-area d-none d-xl-block">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="ltn__top-bar-menu">
                        <ul>
                            <li><a href="locations.html"><i class="icon-placeholder"></i> 67 Ngũ Hành Sơn, Đà
                                    Nẵng</a></li>
                            <li><a href="mailto:minhdien.dev@gmail.com?Subject=Contact%20with%20to%20you"><i
                                        class="icon-mail"></i> khanhhq.21ad@vku.udn.vn</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="top-bar-right text-right text-end">
                        <div class="ltn__top-bar-menu">
                            <ul>
                                <li>
                                    <!-- ltn__social-media -->
                                    <div class="ltn__social-media">
                                        <ul>
                                            <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                            </li>

                                            <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#" title="Dribbble"><i class="fab fa-dribbble"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ltn__header-top-area end -->

    <!-- ltn__header-middle-area start -->
    <div
        class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white sticky-active-into-mobile ltn__logo-right-menu-option plr--9--- d-none d-xl-block">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="site-logo-wrap">
                        <div class="site-logo">
                            <a href="{{ route('home') }}"><img src="{{ asset('assets/clients/img/logo-main.png') }}"
                                    alt="Logo"></a>
                        </div>
                    </div>
                </div>
                <div class="col header-menu-column menu-color-white---">
                    <div class="header-menu d-none d-xl-block">
                        <nav>
                            <div class="ltn__main-menu">
                                <ul>
                                    <li class="menu-icon"><a href="{{ route('home') }}">Trang chủ</a> </li>
                                    <li class="menu-icon"><a href="javascript:void(0)">Về chúng tôi</a>
                                        <ul>
                                            <li><a href="{{ route('about') }}">Về chúng tôi</a></li>
                                            <li><a href="{{ route('service') }}">Dịch vụ</a></li>
                                            <li><a href="{{ route('team') }}">Team</a></li>
                                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-icon"><a href="{{ route('products.index') }}">Cửa hàng</a>
                                    </li>
                                    <li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
                                    <li class="special-link"><a href="{{ route('contact.index') }}">NHẬN BÁO GIÁ</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="ltn__header-options ltn__header-options-2 mb-sm-20">
                    <!-- header-search-1 -->
                    <div class="header-search-wrap">
                        <div class="header-search-1">
                            <div class="search-icon">
                                <i class="icon-search for-search-show"></i>
                                <i class="icon-cancel  for-search-close"></i>
                            </div>
                        </div>
                        <div class="header-search-1-form">
                            <form id="#" method="GET" action="{{ route('search') }}">
                                <input type="text" name="keyword" value="" placeholder="Tìm kiếm..." />
                                <i class="fa fa-microphone" aria-hidden="true" id="voice-search"></i>
                                <button type="submit">
                                    <span><i class="icon-search"></i></span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- user-menu -->
                    <div class="ltn__drop-menu user-menu">
                        <ul>
                            <li>
                                <a href="#"><i class="icon-user"></i></a>
                                <ul>
                                    @if (Auth::check())
                                        <li><a href="{{ route('account') }}">Tài khoản</a></li>
                                        <li><a href="{{ route('wishlist') }}">Yêu thích</a></li>
                                        <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                                    @else
                                        <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                                        <li><a href="{{ route('register') }}">Đăng ký</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- mini-cart -->
                    <div class="mini-cart-icon">
                        <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                            <i class="icon-shopping-cart"></i>
                            <sup id="cart_count" class="cart-count-badge">
                                @auth
                                    {{ \App\Models\CartItem::where('user_id', auth()->id())->count() }}
                                @else
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                @endauth
                            </sup>
                        </a>
                    </div>
                    <!-- mini-cart -->
                    <!-- Mobile Menu Button -->
                    <div class="mobile-menu-toggle d-xl-none">
                        <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                            <svg viewBox="0 0 800 600">
                                <path
                                    d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                    id="top"></path>
                                <path d="M300,320 L540,320" id="middle"></path>
                                <path
                                    d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                    id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ltn__header-middle-area end -->

    <!-- Mobile Header Area start -->
    <div
        class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white sticky-active-into-mobile plr--9--- d-block d-xl-none">
        <div class="container py-2">
            <!-- Row 1: Menu - Logo - Cart -->
            <div class="d-flex align-items-center justify-content-between mb-2">
                <!-- Left: Menu Toggle (logo menu) -->
                <div class="mobile-menu-toggle mobile-menu-toggle-custom">
                    <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle"
                        style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 6px 10px; display: inline-block; background: #0d3a2f;">
                        <svg viewBox="0 0 800 600" style="width: 30px; height: 30px; vertical-align: middle;">
                            <path
                                d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                id="top" stroke="#ffffff" stroke-width="40" stroke-linecap="round" fill="none"></path>
                            <path d="M300,320 L540,320" id="middle" stroke="#ffffff" stroke-width="40"
                                stroke-linecap="round" fill="none"></path>
                            <path
                                d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318)"
                                stroke="#ffffff" stroke-width="40" stroke-linecap="round" fill="none"></path>
                        </svg>
                    </a>
                </div>

                <!-- Center: Main Logo (width: 15%) -->
                <div class="mobile-logo flex-grow-1 d-flex justify-content-center">
                    <a href="{{ route('home') }}" class="d-inline-block text-center"
                        style="width: 15%; min-width: 50px;">
                        <img src="{{ asset('assets/clients/img/logo-main.png') }}" alt="Logo"
                            style="width: 100%; display: block; margin: 0 auto;">
                    </a>
                </div>

                <!-- Right: Cart Icon (logo giỏ hàng) -->
                <div class="mini-cart-icon">
                    <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle"
                        style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 6px 10px; display: inline-block; background: #0d3a2f; position: relative;">
                        <i class="icon-shopping-cart" style="color: #ffffff; font-size: 30px;"></i>
                        <sup class="cart-count-badge"
                            style="position: absolute; top: -5px; right: -5px; background-color: var(--ltn__secondary-color); color: #ffffff; border-radius: 50%; width: 20px; height: 20px; line-height: 20px; font-size: 11px; text-align: center; font-weight: 700; border: 2px solid #0d3a2f; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                            @auth
                                {{ \App\Models\CartItem::where('user_id', auth()->id())->count() }}
                            @else
                                {{ session('cart') ? count(session('cart')) : 0 }}
                            @endauth
                        </sup>
                    </a>
                </div>
            </div>

            <!-- Row 2: Search Input and Search Button wrapped in white -->
            <div class="mobile-search mt-2 mb-1">
                <form method="GET" action="{{ route('search') }}" class="mobile-search-form">
                    <input type="text" name="keyword" class="mobile-search-input" placeholder="Tìm sản phẩm..."
                        required>
                    <button type="submit" class="mobile-search-btn">
                        <i class="icon-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- ltn__header-middle-area end -->
    <!-- ltn__header-middle-area end -->
</header>
<!-- HEADER AREA END -->

<!-- Utilize Cart Menu Start -->
<div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">

    </div>
</div>
<!-- Utilize Cart Menu End -->

@include('clients.partials.utilize_mobile')

<div class="ltn__utilize-overlay"></div>