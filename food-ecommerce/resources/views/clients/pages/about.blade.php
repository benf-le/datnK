@extends('layouts.client')

@section('title', 'Về chúng tôi')
@section('breadcrumb', 'Về chúng tôi')

@section('content')

        <!-- ABOUT US AREA START -->
        <div class="ltn__about-us-area pt-120--- pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <div class="about-us-img-wrap about-img-left">
                            <img src="{{ asset('assets/clients/img/others/6.png') }}" alt="About Us Image">
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-center">
                        <div class="about-us-info-wrap">
                            <div class="section-title-area ltn__section-title-2">
                                <h6 class="section-subtitle ltn__secondary-color">Tìm hiểu thêm về Cửa hàng</h6>
                                <h1 class="section-title">KFood <br class="d-none d-md-block"> Thực phẩm sạch</h1>
                                <p>Tại KFood, chúng tôi mang đến những thực phẩm tươi ngon, an toàn và tốt cho sức khỏe để mỗi bữa
                                    ăn của bạn luôn trọn vẹn yêu thương.</p>
                            </div>
                            <p>KFood tin rằng việc kinh doanh không chỉ là buôn bán, mà còn là cách lan tỏa điều tốt lành.
                                Chúng tôi xây dựng một cộng đồng tin cậy, nơi người bán và người mua cùng chia sẻ những sản phẩm
                                chất lượng, an toàn và mang lại giá trị thật cho cuộc sống.</p>
                            <div class="about-author-info d-flex">
                                <div class="author-name-designation  align-self-center">
                                    <h4 class="mb-0">Hồ Quốc Khánh</h4>
                                    <small>Giám Đốc Cửa Hàng</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ABOUT US AREA END -->

        <!-- FEATURE AREA START ( Feature - 6) -->
        <div class="ltn__feature-area section-bg-1 pt-115 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area ltn__section-title-2 text-center">
                            <h6 class="section-subtitle ltn__secondary-color">Đặc điểm nổi bật</h6>
                            <h1 class="section-title">Tại sao chọn KFood<span>.</span></h1>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="ltn__feature-item ltn__feature-item-7">
                            <div class="ltn__feature-icon-title">
                                <div class="ltn__feature-icon">
                                    <span><img src="{{ asset('assets/clients/img/icons/icon-img/21.png') }}" alt="#"></span>
                                </div>
                                <h3><a href="service-details.html">Thương hiệu đáng tin cậy</a></h3>
                            </div>
                            <div class="ltn__feature-info">
                                <p>KFood hợp tác với nhiều thương hiệu uy tín, mang đến nguồn thực phẩm sạch và chất lượng
                                    cho mọi gia đình Việt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="ltn__feature-item ltn__feature-item-7">
                            <div class="ltn__feature-icon-title">
                                <div class="ltn__feature-icon">
                                    <span><img src="{{ asset('assets/clients/img/icons/icon-img/22.png') }}" alt="#"></span>
                                </div>
                                <h3><a href="service-details.html">Sản phẩm tươi ngon chọn lọc</a></h3>
                            </div>
                            <div class="ltn__feature-info">
                                <p>Mỗi sản phẩm tại KFood đều được chọn lựa cẩn thận, đảm bảo tươi mới, an toàn và giữ
                                    trọn hương vị tự nhiên.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="ltn__feature-item ltn__feature-item-7">
                            <div class="ltn__feature-icon-title">
                                <div class="ltn__feature-icon">
                                    <span><img src="{{ asset('assets/clients/img/icons/icon-img/23.png') }}" alt="#"></span>
                                </div>
                                <h3><a href="service-details.html">Thực phẩm không hóa chất</a></h3>
                            </div>
                            <div class="ltn__feature-info">
                                <p>Chúng tôi nói không với thuốc trừ sâu và chất bảo quản, mang đến nguồn thực phẩm lành mạnh
                                    cho sức khỏe cả nhà.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FEATURE AREA END -->

@endsection