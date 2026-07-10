@extends('layouts.client_home')

@section('title', 'Trang chủ')

@section('content')

    <!-- SLIDER AREA START (slider-3) -->
    <div class="ltn__slider-area ltn__slider-3  section-bg-1">
        <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1">
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3 ltn__slide-item-3-normal bg-image"
                data-bg="{{ asset('assets/clients/img/slider/13.jpg') }}">
                <div class="ltn__slide-item-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <div class="slide-video mb-50 d-none">
                                            <a class="ltn__video-icon-2 ltn__video-icon-2-border"
                                                href="https://www.youtube.com/embed/ATI7vfCgwXE?autoplay=1&amp;showinfo=0"
                                                data-rel="lightcase:myCollection">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div>
                                        <h6 class="slide-sub-title animated"><img
                                                src="{{ asset('assets/clients/img/icons/icon-img/1.png') }}" alt="#">
                                            100% Thực phẩm Tươi - Sạch - An toàn</h6>
                                        <h1 class="slide-title animated ">Tươi Ngon Mỗi Ngày <br> Cùng KFood</h1>
                                        <div class="slide-brief animated">
                                            <p>Mỗi sản phẩm của KFood là một lời cam kết về chất lượng, sự an toàn và giá
                                                trị dinh dưỡng. Chúng tôi tin rằng yêu thương bắt đầu từ những điều giản dị
                                                như bữa cơm nhà mỗi ngày.</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="{{ route('products.index') }}" class="theme-btn-1 btn btn-effect-1 text-uppercase">Khám Phá
                                                Ngay</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__slide-item -->
            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3 ltn__slide-item-3-normal bg-image"
                data-bg="{{ asset('assets/clients/img/slider/14.jpg') }}">
                <div class="ltn__slide-item-inner  text-right text-end">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <h6 class="slide-sub-title ltn__secondary-color animated">THỰC PHẨM SẠCH & CHẤT
                                            LƯỢNG</h6>
                                        <h1 class="slide-title animated ">Món Ngon <br> Từ KFood</h1>
                                        <div class="slide-brief animated">
                                            <p>KFood mang đến những sản phẩm tươi ngon, an toàn và được chọn lọc kỹ lưỡng
                                                từ những nhà cung cấp uy tín, đảm bảo chất lượng cho từng bữa ăn.</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="{{ route('products.index') }}" class="theme-btn-1 btn btn-effect-1 text-uppercase">Mua
                                                Ngay</a>
                                            <a href="about.html" class="btn btn-transparent btn-effect-3">TÌM HIỂU THÊM</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="slide-item-img slide-img-left">
                                                                        <img src="img/slider/22.png" alt="#">
                                                                    </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    <!-- SLIDER AREA END -->

    <!-- BANNER AREA START -->
    @php
        $rauCuCategory = $categories->first(function($cat) {
            return stripos($cat->name, 'rau') !== false || stripos($cat->name, 'quả') !== false || stripos($cat->name, 'trái') !== false || stripos($cat->name, 'củ') !== false;
        });
        $thitCategory = $categories->first(function($cat) {
            return stripos($cat->name, 'thịt') !== false || stripos($cat->name, 'bò') !== false || stripos($cat->name, 'heo') !== false || stripos($cat->name, 'gà') !== false;
        });
        $trungCategory = $categories->first(function($cat) {
            return stripos($cat->name, 'trứng') !== false;
        });
    @endphp

    <style>
        .custom-banner-section {
            margin-top: 120px;
            margin-bottom: 90px;
        }
        .custom-banner-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            height: 100%;
            min-height: 500px;
            display: flex;
            align-items: flex-end;
            margin-bottom: 30px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }
        .custom-banner-card.small-card {
            min-height: 235px;
            align-items: center;
        }
        .custom-banner-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: 1;
        }
        .custom-banner-card:hover .custom-banner-bg {
            transform: scale(1.08);
        }
        .custom-banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 50%, rgba(255, 255, 255, 0) 100%);
            z-index: 2;
            transition: all 0.4s ease;
        }
        .custom-banner-card.tall-card .custom-banner-overlay {
            background: linear-gradient(to top, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.85) 55%, rgba(255, 255, 255, 0) 100%);
        }
        .custom-banner-content {
            position: relative;
            z-index: 3;
            padding: 40px;
            width: 100%;
        }
        .custom-banner-card.tall-card .custom-banner-content {
            max-width: 90%;
        }
        .custom-banner-card.small-card .custom-banner-content {
            max-width: 65%;
            padding: 30px 40px;
        }
        .custom-banner-tag {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #5d9e19;
            margin-bottom: 10px;
            padding: 4px 12px;
            background-color: rgba(93, 158, 25, 0.08);
            border-radius: 4px;
        }
        .custom-banner-title {
            font-size: 32px;
            font-weight: 800;
            color: #0d3a2f;
            line-height: 1.25;
            margin-bottom: 12px;
        }
        .custom-banner-card.small-card .custom-banner-title {
            font-size: 24px;
            margin-bottom: 8px;
        }
        .custom-banner-desc {
            font-size: 14px;
            color: #666;
            margin-bottom: 22px;
            line-height: 1.6;
        }
        .custom-banner-card.small-card .custom-banner-desc {
            font-size: 13.5px;
            margin-bottom: 16px;
            line-height: 1.5;
        }
        .custom-banner-btn {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            font-weight: 700;
            color: #ffffff !important;
            background-color: #5d9e19;
            padding: 10px 24px;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(93, 158, 25, 0.2);
            border: none;
        }
        .custom-banner-btn:hover {
            background-color: #0d3a2f;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 58, 47, 0.3);
        }
        .custom-banner-btn i {
            margin-left: 8px;
            font-size: 11px;
            transition: transform 0.3s ease;
        }
        .custom-banner-btn:hover i {
            transform: translateX(4px);
        }
        
        @media (max-width: 1199px) {
            .custom-banner-card {
                min-height: 460px;
            }
            .custom-banner-card.small-card {
                min-height: 215px;
            }
            .custom-banner-title {
                font-size: 28px;
            }
            .custom-banner-card.small-card .custom-banner-title {
                font-size: 22px;
            }
        }
        @media (max-width: 991px) {
            .custom-banner-card {
                min-height: 420px;
            }
            .custom-banner-card.small-card {
                min-height: 220px;
            }
            .custom-banner-title {
                font-size: 24px;
            }
            .custom-banner-card.small-card .custom-banner-title {
                font-size: 20px;
            }
        }
        @media (max-width: 767px) {
            .custom-banner-card {
                min-height: 360px;
            }
            .custom-banner-card.small-card {
                min-height: 240px;
                align-items: flex-end;
            }
            .custom-banner-card.small-card .custom-banner-overlay {
                background: linear-gradient(to top, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.85) 60%, rgba(255, 255, 255, 0.1) 100%);
            }
            .custom-banner-card.small-card .custom-banner-content {
                max-width: 100%;
                padding: 24px;
            }
        }
    </style>

    <div class="ltn__banner-area custom-banner-section">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Left Banner: Rau Củ Quả & Trái Cây -->
                <div class="col-lg-6 col-md-6 mb-30">
                    <div class="custom-banner-card tall-card">
                        <div class="custom-banner-bg" style="background-image: url('{{ asset('assets/clients/img/banner/banner_rau_cu.png') }}');"></div>
                        <div class="custom-banner-overlay"></div>
                        <div class="custom-banner-content">
                            <span class="custom-banner-tag">100% Organic</span>
                            <h2 class="custom-banner-title">Rau Củ Quả<br>& Trái Cây Sạch</h2>
                            <p class="custom-banner-desc">Rau lá xanh tươi, củ quả hữu cơ thu hoạch trong ngày từ trang trại chuẩn VietGAP.</p>
                            <a href="{{ $rauCuCategory ? route('products.index', ['category_id' => $rauCuCategory->id]) : route('products.index') }}" class="custom-banner-btn">Mua Ngay <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Right Banners -->
                <div class="col-lg-6 col-md-6">
                    <div class="row">
                        <!-- Top Right Banner: Thịt Tươi Sống -->
                        <div class="col-lg-12 mb-30">
                            <div class="custom-banner-card small-card">
                                <div class="custom-banner-bg" style="background-image: url('{{ asset('assets/clients/img/banner/banner_thit_tuoi.png') }}');"></div>
                                <div class="custom-banner-overlay"></div>
                                <div class="custom-banner-content">
                                    <span class="custom-banner-tag">Thịt Tươi Sống</span>
                                    <h2 class="custom-banner-title">Thịt Heo, Bò, Gà Sạch</h2>
                                    <p class="custom-banner-desc">Thịt tươi ngon mỗi ngày, đóng gói hút chân không, bảo quản nghiêm ngặt.</p>
                                    <a href="{{ $thitCategory ? route('products.index', ['category_id' => $thitCategory->id]) : route('products.index') }}" class="custom-banner-btn">Xem Ngay <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Right Banner: Trứng Gà, Vịt, Cút -->
                        <div class="col-lg-12 mb-30">
                            <div class="custom-banner-card small-card">
                                <div class="custom-banner-bg" style="background-image: url('{{ asset('assets/clients/img/banner/banner_trung_sach.png') }}');"></div>
                                <div class="custom-banner-overlay"></div>
                                <div class="custom-banner-content">
                                    <span class="custom-banner-tag">Trang Trại Sạch</span>
                                    <h2 class="custom-banner-title">Trứng Gà, Vịt, Cút</h2>
                                    <p class="custom-banner-desc">Trứng tươi mới tuyển chọn từ trang trại sinh thái, giàu dinh dưỡng.</p>
                                    <a href="{{ $trungCategory ? route('products.index', ['category_id' => $trungCategory->id]) : route('products.index') }}" class="custom-banner-btn">Xem Ngay <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER AREA END -->

    <!-- CATEGORY AREA START -->
    <div class="ltn__category-area section-bg-1-- ltn__primary-bg before-bg-1 bg-image bg-overlay-theme-black-5--0 pt-115 pb-90"
        data-bg="{{ asset('assets/clients/img/bg/5.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title white-color">Danh mục</h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__category-slider-active slick-arrow-1">
                @foreach ($categories as $category)
                    <div class="col-12">
                        <div class="ltn__category-item ltn__category-item-3 text-center">
                            <div class="ltn__category-item-img">
                                <a href="{{ route('products.index', ['category_id' => $category->id]) }}">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                </a>
                            </div>
                            <div class="ltn__category-item-name">
                                <h5><a href="{{ route('products.index', ['category_id' => $category->id]) }}">{{ $category->name }}</a></h5>
                                <h6>({{ $category->products->count() }} sản phẩm)</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- CATEGORY AREA END -->

    <!-- PRODUCT TAB AREA START (product-item-3) -->
    <div class="ltn__product-tab-area ltn__product-gutter pt-115 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title">Sản phẩm</h1>
                    </div>
                    <div class="ltn__tab-menu ltn__tab-menu-2 ltn__tab-menu-top-right-- text-uppercase text-center">
                        <div class="nav">
                            @foreach ($categories as $index => $category)
                                <a class="{{ $index == 0 ? 'active show' : '' }}" data-bs-toggle="tab"
                                    href="#tab_{{ $category->id }}">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-content">
                        @foreach ($categories as $index => $category)
                            <div class="tab-pane fade {{ $index == 0 ? 'active show' : '' }}" id="tab_{{ $category->id }}">
                                <div class="ltn__product-tab-content-inner">
                                    <div class="row ltn__tab-product-slider-one-active slick-arrow-1">
                                        @foreach ($category->products as $product)
                                            <div class="col-lg-12">
                                                <div class="ltn__product-item ltn__product-item-3 text-center">
                                                    <div class="product-img">
                                                        <a href="{{ route('product.detail', $product->slug) }}"><img src="{{ $product->image_url }}"
                                                                alt="{{ $product->name }}"></a>
                                                        <div class="product-hover-action">
                                                            <ul>
                                                                <li>
                                                                    <a href="#" title="Xem nhanh" data-bs-toggle="modal"
                                                                        data-bs-target="#quick_view_modal-{{ $product->id }}">
                                                                        <i class="far fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" title="Thêm vào giỏ hàng" class="add-to-cart-btn"
                                                                        data-id="{{ $product->id }}">
                                                                        <i class="fas fa-shopping-cart"></i>
                                                                    </a>

                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" title="Yêu thích" class="add-to-wishlist"
                                                                        data-id="{{ $product->id }}">
                                                                        <i class="far fa-heart"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="product-ratting">
                                                            @include('clients.components.includes.rating', ['product' => $product])
                                                        </div>
                                                        <h2 class="product-title"><a
                                                                href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                                        </h2>
                                                        <div class="product-price">
                                                            <span>{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @foreach ($category->products as $product)
                                        @include('clients.components.includes.include-modals')
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT TAB AREA END -->

    <!-- COUNTER UP AREA START -->
    <div class="ltn__counterup-area bg-image bg-overlay-theme-black-80 pt-115 pb-70"
        data-bg="{{ asset('assets/clients/img/bg/5.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/2.png') }}"
                                alt="#"> </div>
                        <h1><span class="counter">733</span><span class="counterUp-icon">+</span> </h1>
                        <h6>Khách Hàng Tin Dùng</h6>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/3.png') }}"
                                alt="#"> </div>
                        <h1><span class="counter">33</span><span class="counterUp-letter">K</span><span
                                class="counterUp-icon">+</span> </h1>
                        <h6>Sản Phẩm Đã Bán</h6>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/4.png') }}"
                                alt="#"> </div>
                        <h1><span class="counter">100</span><span class="counterUp-icon">+</span> </h1>
                        <h6>Đánh Giá 5 Sao</h6>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/5.png') }}"
                                alt="#"> </div>
                        <h1><span class="counter">21</span><span class="counterUp-icon">+</span> </h1>
                        <h6>Tỉnh Thành Phân Phối</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- COUNTER UP AREA END -->

    <!-- PRODUCT AREA START (product-item-3) -->
    <div class="ltn__product-area ltn__product-gutter pt-115 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title">Sản phẩm bán chạy</h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__tab-product-slider-one-active slick-arrow-1">
                @foreach ($bestSellingProducts as $product)
                    <div class="col-lg-12">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="{{ route('product.detail', $product->slug) }}"><img src="{{ $product->image_url }}" alt="{{ $product->name }}"></a>
                                <div class="product-hover-action">
                                    <ul>
                                        <li>
                                            <a href="#" title="Xem nhanh" data-bs-toggle="modal"
                                                data-bs-target="#quick_view_modal-{{ $product->id }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Thêm vào giỏ hàng" class="add-to-cart-btn"
                                                data-id="{{ $product->id }}">
                                                <i class=" fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" title="Yêu thích" class="add-to-wishlist"
                                                data-id="{{ $product->id }}">
                                                <i class="far fa-heart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    @include('clients.components.includes.rating', ['product' => $product])
                                </div>
                                <h2 class="product-title"><a
                                        href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h2>
                                <div class="product-price">
                                    <span>{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                                </div>
                                <div class="product-sold" style="font-size: 13px; color: #777; margin-top: 5px;">
                                    <span>Đã bán: <strong>{{ $product->total_sold ?? 0 }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @foreach ($bestSellingProducts as $product)
                @include('clients.components.includes.include-modals')
            @endforeach
        </div>
    </div>
    <!-- PRODUCT AREA END -->

    <!-- CALL TO ACTION START (call-to-action-4) -->
    <div class="ltn__call-to-action-area ltn__call-to-action-4 bg-image pt-115 pb-120"
        data-bg="{{ asset('assets/clients/img/bg/6.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="call-to-action-inner call-to-action-inner-4 text-center">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">bạn cần tư vấn?</h6>
                            <h1 class="section-title white-color">0994 913 686</h1>
                        </div>
                        <div class="btn-wrapper">
                            <a href="tel:0994913686" class="theme-btn-1 btn btn-effect-1">GỌI NGAY</a>
                            <a href="contact.html" class="btn btn-transparent btn-effect-4 white-color">LIÊN HỆ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ltn__call-to-4-img-1">
            <img src="{{ asset('assets/clients/img/bg/12.png') }}" alt="#">
        </div>
        <div class="ltn__call-to-4-img-2">
            <img src="{{ asset('assets/clients/img/bg/11.png') }}" alt="#">
        </div>
    </div>
    <!-- CALL TO ACTION END -->

    {{-- <!-- MODAL AREA START (Quick View Modal) -->
    <div class="ltn__modal-area ltn__quick-view-modal-area">
        <div class="modal fade" id="quick_view_modal" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <!-- <i class="fas fa-times"></i> -->
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-img">
                                            <img src="img/product/4.png" alt="#">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-info">
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                    <li><a href="#"><i class="far fa-star"></i></a></li>
                                                    <li class="review-total"> <a href="#"> ( 95 Reviews )</a></li>
                                                </ul>
                                            </div>
                                            <h3>Vegetables Juices</h3>
                                            <div class="product-price">
                                                <span>$149.00</span>
                                                <del>$165.00</del>
                                            </div>
                                            <div class="modal-product-meta ltn__product-details-menu-1">
                                                <ul>
                                                    <li>
                                                        <strong>Categories:</strong>
                                                        <span>
                                                            <a href="#">Parts</a>
                                                            <a href="#">Car</a>
                                                            <a href="#">Seat</a>
                                                            <a href="#">Cover</a>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="ltn__product-details-menu-2">
                                                <ul>
                                                    <li>
                                                        <div class="cart-plus-minus">
                                                            <input type="text" value="02" name="qtybutton"
                                                                class="cart-plus-minus-box">
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="theme-btn-1 btn btn-effect-1" title="Add to Cart"
                                                            data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            <span>ADD TO CART</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="ltn__product-details-menu-3">
                                                <ul>
                                                    <li>
                                                        <a href="#" class="" title="Wishlist" data-bs-toggle="modal"
                                                            data-bs-target="#liton_wishlist_modal">
                                                            <i class="far fa-heart"></i>
                                                            <span>Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="" title="Compare" data-bs-toggle="modal"
                                                            data-bs-target="#quick_view_modal">
                                                            <i class="fas fa-exchange-alt"></i>
                                                            <span>Compare</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <hr>
                                            <div class="ltn__social-media">
                                                <ul>
                                                    <li>Share:</li>
                                                    <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                                    </li>
                                                    <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a>
                                                    </li>
                                                    <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->

    <!-- MODAL AREA START (Add To Cart Modal) -->
    <div class="ltn__modal-area ltn__add-to-cart-modal-area">
        <div class="modal fade" id="add_to_cart_modal" tabindex="-1">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="modal-product-img">
                                            <img src="img/product/1.png" alt="#">
                                        </div>
                                        <div class="modal-product-info">
                                            <h5><a href="{{ route('product.detail', $product->slug) }}">Vegetables
                                                    Juices</a></h5>
                                            <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully
                                                added to your Cart</p>
                                            <div class="btn-wrapper">
                                                <a href="{{route('cart.index')}}" class="theme-btn-1 btn btn-effect-1">View
                                                    Cart</a>
                                                <a href="checkout.html" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                                            </div>
                                        </div>
                                        <!-- additional-info -->
                                        <div class="additional-info d-none">
                                            <p>We want to give you <b>10% discount</b> for your first order, <br>
                                                Use discount code at checkout</p>
                                            <div class="payment-method">
                                                <img src="img/icons/payment.png" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->

    <!-- MODAL AREA START (Wishlist Modal) -->
    <div class="ltn__modal-area ltn__add-to-cart-modal-area">
        <div class="modal fade" id="liton_wishlist_modal" tabindex="-1">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="modal-product-img">
                                            <img src="img/product/7.png" alt="#">
                                        </div>
                                        <div class="modal-product-info">
                                            <h5><a href="{{ route('product.detail', $product->slug) }}">Vegetables
                                                    Juices</a></h5>
                                            <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully
                                                added to your Wishlist</p>
                                            <div class="btn-wrapper">
                                                <a href="wishlist.html" class="theme-btn-1 btn btn-effect-1">View
                                                    Wishlist</a>
                                            </div>
                                        </div>
                                        <!-- additional-info -->
                                        <div class="additional-info d-none">
                                            <p>We want to give you <b>10% discount</b> for your first order, <br>
                                                Use discount code at checkout</p>
                                            <div class="payment-method">
                                                <img src="img/icons/payment.png" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END --> --}}
@endsection