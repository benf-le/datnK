@extends('layouts.client')

@section('title', 'Dịch vụ')
@section('breadcrumb', 'Dịch vụ')

@section('content')

    <!-- ABOUT US AREA START -->
    <div class="ltn__about-us-area pb-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 align-self-center">
                    <div class="about-us-img-wrap ltn__img-shape-left  about-img-left">
                        <img src="{{ asset('assets/clients/img/service/11.jpg') }}" alt="Image">
                    </div>
                </div>
                <div class="col-lg-7 align-self-center">
                    <div class="about-us-info-wrap">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color"> DỊCH VỤ UY TÍN </h6>
                            <h1 class="section-title">KFood – Dịch vụ chuyên nghiệp và tận tâm<span>.</span></h1>
                            <p>Chúng tôi cam kết mang đến những sản phẩm chất lượng, an toàn cùng dịch vụ chu đáo để khách
                                hàng luôn an tâm khi lựa chọn KFood.</p>
                        </div>
                        <div class="about-us-info-wrap-inner about-us-info-devide">
                            <p>KFood không chỉ chú trọng đến chất lượng sản phẩm mà còn quan tâm đến trải nghiệm của từng
                                khách hàng.
                                Chúng tôi luôn nỗ lực mang đến những giá trị thiết thực, góp phần xây dựng cuộc sống xanh và
                                khỏe mạnh cho mọi gia đình Việt.</p>
                            <div class="list-item-with-icon">
                                <ul>
                                    <li><a href="javascript:void(0)">Giao hàng nội thành phí 25.000đ</a></li>
                                    <li><a href="javascript:void(0)">Đội ngũ chuyên môn tận tâm</a></li>
                                    <li><a href="javascript:void(0)">Thiết bị đảm bảo vệ sinh</a></li>
                                    <li><a href="javascript:void(0)">Đa dạng sản phẩm cho mọi nhu cầu</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT US AREA END -->

    <!-- SERVICE AREA START (Service 1) -->
    <div class="ltn__service-area section-bg-1 pt-115 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title white-color---">Dịch Vụ Của Chúng Tôi</h1>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">

                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="javascript:void(0)"><img src="{{ asset('assets/clients/img/service/2.jpg') }}"
                                    alt="Trái cây tươi sạch"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="javascript:void(0)">Trái cây tươi sạch</a></h3>
                            <p>Những loại trái cây giàu dinh dưỡng, được thu hoạch từ các nông trại an toàn và đạt tiêu
                                chuẩn chất lượng cao.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="javascript:void(0)"><img src="{{ asset('assets/clients/img/service/3.jpg') }}"
                                    alt="Thực phẩm tươi sống"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="javascript:void(0)">Thực phẩm tươi sống</a></h3>
                            <p>Cung cấp các loại thịt sống chất lượng cao, có nguồn gốc rõ ràng và bảo
                                quản an toàn.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="javascript:void(0)"><img src="{{ asset('assets/clients/img/service/2.jpg') }}"
                                    alt="Giao hàng tận nơi"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="javascript:void(0)">Giao hàng tận nơi</a></h3>
                            <p>Phí giao hàng của KFood là hoàn toàn 25000đ trong khu vực nội thành.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- SERVICE AREA END -->



@endsection