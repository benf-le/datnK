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
                            <a href="javascript:void(0)"><img src="{{ asset('assets/clients/img/service/1.jpg') }}"
                                    alt="Rau củ hữu cơ"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="javascript:void(0)">Rau củ hữu cơ</a></h3>
                            <p>KFood cung cấp các loại rau củ tươi ngon, trồng theo quy trình tự nhiên, không hóa chất độc
                                hại.</p>
                        </div>
                    </div>
                </div>

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
                                    alt="Thực phẩm chế biến sẵn"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="javascript:void(0)">Thực phẩm chế biến sẵn</a></h3>
                            <p>Các sản phẩm chế biến từ nguồn nguyên liệu sạch, tiện lợi mà vẫn giữ trọn vị ngon tự nhiên.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="javascript:void(0)"><img src="{{ asset('assets/clients/img/service/3.jpg') }}"
                                    alt="Sản phẩm khô và ngũ cốc"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="javascript:void(0)">Sản phẩm khô & ngũ cốc</a></h3>
                            <p>Các loại hạt, ngũ cốc, thực phẩm khô được bảo quản kỹ lưỡng, giữ nguyên hương vị và giá trị
                                dinh dưỡng.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="ltn__service-item-1">
                        <div class="service-item-img">
                            <a href="javascript:void(0)"><img src="{{ asset('assets/clients/img/service/1.jpg') }}"
                                    alt="Đồ uống thiên nhiên"></a>
                        </div>
                        <div class="service-item-brief">
                            <h3><a href="javascript:void(0)">Đồ uống thiên nhiên</a></h3>
                            <p>Tận hưởng các loại nước ép và trà thảo mộc tươi mát, giúp thanh lọc cơ thể và bổ sung năng
                                lượng mỗi ngày.</p>
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
                             <p>Phí giao hàng của KFood là hoàn toàn 25000đ trong khu vực nội thành. KFood sẽ giao hàng tận nhà trong thời gian nhanh nhất có thể sau khi khách xác nhận đơn hàng.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- SERVICE AREA END -->

    <!-- OUR JOURNEY AREA START -->
    <div class="ltn__our-journey-area bg-image bg-overlay-theme-90 pt-280 pb-350 mb-35 plr--9" data-bg="img/bg/8.jpg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__our-journey-wrap ">
                        <ul>
                            <li>
                                <span class="ltn__journey-icon">1900</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/history-1.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Khởi đầu từ đam mê nông nghiệp</h3>
                                                <p>KFood được hình thành từ niềm tin rằng thực phẩm sạch là nền tảng cho
                                                    một cuộc sống khỏe mạnh. Từ những trang trại nhỏ, chúng tôi bắt đầu
                                                    trồng trọt theo hướng tự nhiên, không hóa chất.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="active">
                                <span class="ltn__journey-icon">1950</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/history-1.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Thành lập thương hiệu KFood</h3>
                                                <p>Chúng tôi chính thức ra mắt thương hiệu KFood – chuyên cung cấp nông
                                                    sản hữu cơ, được chứng nhận an toàn và đạt chuẩn chất lượng quốc tế.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <span class="ltn__journey-icon">1994</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/history-1.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Mở rộng hệ thống phân phối</h3>
                                                <p>KFood bắt đầu hợp tác với các chuỗi siêu thị và cửa hàng thực phẩm
                                                    sạch, giúp sản phẩm hữu cơ đến gần hơn với mọi gia đình.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <span class="ltn__journey-icon">2010</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/history-1.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Chuyển mình cùng công nghệ</h3>
                                                <p>Ứng dụng nền tảng thương mại điện tử, KFood phát triển hệ thống bán
                                                    hàng trực tuyến, giúp khách hàng dễ dàng đặt mua thực phẩm tươi ngon mọi
                                                    lúc mọi nơi.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <span class="ltn__journey-icon">2020</span>
                                <ul>
                                    <li>
                                        <div class="ltn__journey-history-item-info clearfix">
                                            <div class="ltn__journey-history-img">
                                                <img src="{{ asset('assets/clients/img/service/history-1.jpg') }}" alt="#">
                                            </div>
                                            <div class="ltn__journey-history-info">
                                                <h3>Thương hiệu thực phẩm xanh hàng đầu</h3>
                                                <p>KFood trở thành một trong những thương hiệu dẫn đầu trong lĩnh vực thực
                                                    phẩm hữu cơ, góp phần lan tỏa lối sống xanh – sạch – bền vững đến cộng
                                                    đồng.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- OUR JOURNEY AREA END -->

@endsection