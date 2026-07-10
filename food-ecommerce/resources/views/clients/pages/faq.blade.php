@extends('layouts.client')

@section('title', 'FAQ')
@section('breadcrumb', 'Những câu hỏi thường gặp')

@section('content')

    <!-- FAQ AREA START (faq-2) -->
    <div class="ltn__faq-area mb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="ltn__faq-inner ltn__faq-inner-2">
                        <div id="accordion_2">
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                    data-bs-target="#faq-item-2-1" aria-expanded="false">
                                    Làm thế nào để đặt mua sản phẩm?
                                </h6>
                                <div id="faq-item-2-1" class="collapse" data-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Bạn chỉ cần chọn sản phẩm mong muốn, thêm vào giỏ hàng và điền thông tin giao
                                            hàng. Sau khi xác nhận đơn, đội ngũ KFood sẽ liên hệ xác nhận và giao đến tận
                                            nhà nhanh nhất có thể.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2"
                                    aria-expanded="true">
                                    Làm sao để đổi trả hoặc hoàn tiền?
                                </h6>
                                <div id="faq-item-2-2" class="collapse show" data-parent="#accordion_2">
                                    <div class="card-body">
                                        {{-- <div class="ltn__video-img alignleft">
                                            <img src="{{ asset('assets/clients/img/img/bg/17.jpg') }}" alt="video popup bg image">
                                            <a class="ltn__video-icon-2 ltn__video-icon-2-small ltn__video-icon-2-border----"
                                                href="https://www.youtube.com/embed/LjCzPp-MK48?autoplay=1&amp;showinfo=0"
                                                data-rel="lightcase:myCollection">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div> --}}
                                        <p>KFood chấp nhận đổi trả trong vòng <b>3 ngày</b> nếu sản phẩm bị hư hỏng, sai
                                            loại hoặc không đạt chất lượng như cam kết. Liên hệ ngay với bộ phận chăm sóc
                                            khách hàng để được hỗ trợ nhanh nhất.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                    data-bs-target="#faq-item-2-3" aria-expanded="false">
                                    Tôi là khách hàng mới, bắt đầu như thế nào?
                                </h6>
                                <div id="faq-item-2-3" class="collapse" data-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Bạn chỉ cần tạo tài khoản, đăng nhập và duyệt các sản phẩm tươi sạch tại KFood.
                                            Chọn sản phẩm yêu thích, thêm vào giỏ và đặt hàng – chúng tôi sẽ lo phần còn
                                            lại.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                    data-bs-target="#faq-item-2-4" aria-expanded="false">
                                    Chính sách đổi trả của KFood
                                </h6>
                                <div id="faq-item-2-4" class="collapse" data-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Chúng tôi cam kết mang đến sản phẩm chất lượng cao nhất. Nếu có lỗi từ sản phẩm,
                                            Hậu có thể yêu cầu đổi trả trong vòng 3 ngày kể từ khi nhận hàng. KFood sẽ
                                            hoàn tiền hoặc đổi sản phẩm mới tùy tình huống cụ thể.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                    data-bs-target="#faq-item-2-5" aria-expanded="false">
                                    Thông tin cá nhân của tôi có được bảo mật không?
                                </h6>
                                <div id="faq-item-2-5" class="collapse" data-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>KFood tuyệt đối bảo mật thông tin cá nhân của khách hàng. Mọi dữ liệu chỉ được
                                            sử dụng để phục vụ đơn hàng và chăm sóc sau bán hàng, không chia sẻ cho bên thứ
                                            ba.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                    data-bs-target="#faq-item-2-6" aria-expanded="false">
                                    Mã giảm giá không sử dụng được thì sao?
                                </h6>
                                <div id="faq-item-2-6" class="collapse" data-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Hãy kiểm tra xem mã còn hạn sử dụng hay không, hoặc có áp dụng cho sản phẩm Hậu
                                            đang chọn không. Nếu vẫn không được, liên hệ hỗ trợ để KFood giúp kích hoạt
                                            hoặc cấp mã mới.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->
                            <div class="card">
                                <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                    data-bs-target="#faq-item-2-7" aria-expanded="false">
                                    Tôi có thể thanh toán bằng thẻ tín dụng không?
                                </h6>
                                <div id="faq-item-2-7" class="collapse" data-parent="#accordion_2">
                                    <div class="card-body">
                                        <p>Có! KFood hỗ trợ thanh toán bằng thẻ tín dụng, thẻ ghi nợ, ví điện tử và chuyển
                                            khoản ngân hàng. Tất cả đều được mã hóa bảo mật để đảm bảo an toàn tuyệt đối.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="need-support text-center mt-100">
                            <h2>Vẫn cần hỗ trợ? Liên hệ với chúng tôi 24/7:</h2>
                            <div class="btn-wrapper mb-30">
                                <a href="contact.html" class="theme-btn-1 btn">Liên hệ ngay</a>
                            </div>
                            <h3><i class="fas fa-phone"></i> 0994 913 686</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <aside class="sidebar-area ltn__right-sidebar">
                        <!-- Newsletter Widget -->
                        <div class="widget ltn__search-widget ltn__newsletter-widget">
                            <h6 class="ltn__widget-sub-title">Đăng ký</h6>
                            <h4 class="ltn__widget-title">Nhận tin mới</h4>
                            <form action="#">
                                <input type="text" name="search" placeholder="Nhập email của bạn...">
                                <button type="submit"><i class="fas fa-paper-plane"></i></button>
                            </form>
                            <div class="ltn__newsletter-bg-icon">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                        </div>
                        <!-- Banner Widget -->
                        <div class="widget ltn__banner-widget">
                            <a href="{{ route('products.index') }}"><img src="{{ asset('assets/clients/img/banner/banner-3.jpg') }}" alt="Banner Image"></a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ AREA END -->

    <!-- COUNTER UP AREA START -->
    <div class="ltn__counterup-area bg-image bg-overlay-theme-black-80 pt-115 pb-70" data-bg="{{ asset('assets/clients/img/bg/5.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/2.png') }}" alt="#"> </div>
                        <h1><span class="counter">500</span><span class="counterUp-icon">+</span> </h1>
                        <h6>Khách hàng hài lòng</h6>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/3.png') }}" alt="#"> </div>
                        <h1><span class="counter">10</span><span class="counterUp-letter">K</span><span
                                class="counterUp-icon">+</span> </h1>
                        <h6>Đơn hàng giao thành công</h6>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/4.png') }}" alt="#"> </div>
                        <h1><span class="counter">100</span><span class="counterUp-icon">%</span> </h1>
                        <h6>Thực phẩm tươi sạch</h6>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 align-self-center">
                    <div class="ltn__counterup-item-3 text-color-white text-center">
                        <div class="counter-icon"> <img src="{{ asset('assets/clients/img/icons/icon-img/5.png') }}" alt="#"> </div>
                        <h1><span class="counter">15</span><span class="counterUp-icon">+</span> </h1>
                        <h6>Tỉnh thành phục vụ</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- COUNTER UP AREA END -->

@endsection