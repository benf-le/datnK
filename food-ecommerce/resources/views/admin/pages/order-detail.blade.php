@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')
@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Hóa Đơn</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Chi Tiết Hóa Đơn</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <section class="content invoice">
                                <!-- title row -->
                                <div class="row">
                                    <div class="invoice-header">
                                        <p class="text-muted">Ngày tạo: {{ $order->created_at }}</p>
                                    </div>
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Từ:
                                        <address>
                                            <strong>{{ $order->shippingAddress ? $order->shippingAddress->full_name : 'N/A' }}</strong>
                                            <br>{{ $order->shippingAddress ? $order->shippingAddress->address : 'N/A' }}
                                            <br>{{ $order->shippingAddress ? $order->shippingAddress->city : 'N/A' }}
                                            <br>Số điện thoại: {{ $order->shippingAddress ? $order->shippingAddress->phone : 'N/A' }}
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Đến:
                                        <address>
                                            <strong>KFood</strong>
                                            <br>67 Ngũ Hành Sơn
                                            <br>Đà Nẵng
                                            <br>Số điện thoại: 0994 913 686
                                            <br>Email: khanhhq.21ad@vku.udn.vn
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Order ID: #{{ $order->id }}</b>
                                        <br>
                                        <b>Email: {{ $order->user ? $order->user->email : 'N/A' }}</b>
                                        <br>
                                        <b>Tài khoản: {{ $order->user ? $order->user->name : 'Tài khoản đã bị xóa' }}</b>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="  table">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ảnh</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderItems as $item)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ $item->product ? $item->product->image_url : '#' }}" alt="{{ $item->product ? $item->product->name : 'N/A' }}" width="50px" border-radius="6px">
                                                        </td>
                                                        <td>{{ $item->product ? $item->product->name : 'Sản phẩm đã bị xóa' }}</td>
                                                        <td>{{ number_format($item->price, 0, ',', '.') }} ₫ </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-md-6">
                                        <p class="lead">Phương thức thanh toán:</p>
                                        @if ($order->payment && $order->payment->payment_method == 'paypal')
                                            <img src="{{ asset('assets/admin/images/paypal.png') }}" alt="Paypal">
                                        @else
                                            <img src="{{ asset('assets/admin/images/cash.jpg') }}"
                                                alt="Thanh toán khi nhận hàng" width="100px" height="70px">
                                        @endif

                                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                            Chúng tôi mang đến cho bạn những lựa chọn thanh toán linh hoạt, an toàn và tiện
                                            lợi nhất.
                                            Mỗi giao dịch đều được mã hóa và xử lý theo tiêu chuẩn cao cấp, đảm bảo sự an
                                            tâm tuyệt đối trong suốt hành trình mua sắm của bạn.
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:50%">Tổng tiền hàng:</th>
                                                        <td>{{ number_format($order->total_price -25000, 0, ',', '.') }} ₫ </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phí vận chuyển:</th>
                                                        <td>{{ number_format(25000, 0, ',', '.') }} ₫ </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Thành tiền:</th>
                                                        <td>{{ number_format($order->total_price, 0, ',', '.') }} ₫ </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div>
                                        @if ($order->status != 'canceled')
                                            <button class="btn btn-default" onclick="window.print();"><i
                                                    class="fa fa-print"></i> In hóa đơn</button>
                                            <button class="btn btn-success pull-right send-invoice-mail" data-id="{{ $order->id }}"><i class="fa fa-send"></i> Gửi hóa
                                                đơn</button>

                                            @if($order->status == 'pending')
                                                <button class="btn btn-danger pull-right cancel-order" style="margin-right: 5px;"
                                                    data-id="{{ $order->id }}">
                                                    <i class="fa fa-remove"></i> Hủy đơn hàng
                                                </button>
                                            @endif

                                        @else
                                            <button class="btn btn-danger" style="cursor: not-allowed;"><i
                                                    class="fa fa-times"></i> Đơn hàng đã hủy</button>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection