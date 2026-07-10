@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')
@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Quản Lý Đơn Hàng<small></small></h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Danh Sách Đơn Hàng </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <p class="text-muted font-13 m-b-30">
                                            Hệ thống quản trị của KFood Store được xây dựng như trái tim của toàn bộ
                                            website, nơi mọi chi tiết đều được chăm chút tỉ mỉ. Tại đây, bạn có thể theo dõi
                                            sản phẩm, đơn hàng và khách hàng một cách nhẹ nhàng, trôi chảy. Mỗi thao tác đều
                                            được tinh giản để mang đến cảm giác chuyên nghiệp, tin cậy và đầy cảm hứng trong
                                            hành trình phát triển thương hiệu.
                                        </p>
                                        <table id="datatable-buttons" class="table table-striped table-bordered"
                                            style="width:100%; text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Tài khoản</th>
                                                    <th>Thông tin người đặt</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Trạng thái đơn hàng</th>
                                                    <th>Trạng thái thanh toán</th>
                                                    <th>Chi tiết đơn hàng</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->user ? $order->user->name : 'Tài khoản đã bị xóa' }}</td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#addressShippingModal-{{ $order->id }}">{{ $order->shippingAddress ? $order->shippingAddress->address : 'N/A' }}</a>
                                                        </td>
                                                        <td>{{ number_format($order->total_price, 0, ',', '.') }} ₫ </td>
                                                        <td class="order-status">
                                                            @if ($order->status == 'pending')
                                                                <span class="custom-badge badge badge-warning">Chờ xác nhận</span>
                                                            @elseif ($order->status == 'processing')
                                                                <span class="custom-badge badge badge-primary">Đang giao hàng</span>
                                                            @elseif ($order->status == 'completed')
                                                                <span class="custom-badge badge badge-success">Đã hoàn thành</span>
                                                            @elseif ($order->status == 'canceled')
                                                                <span class="custom-badge badge badge-danger">Đã hủy</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!$order->payment || $order->payment->status == 'pending')
                                                                <span class="custom-badge badge badge-danger">Chưa thanh toán</span>
                                                            @else
                                                                <span class="custom-badge badge badge-success">Đã thanh toán</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#orderItemsModal-{{ $order->id }}">Xem</button>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-danger dropdown-toggle dropdown-toggle-split"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @if ($order->status == 'pending')
                                                                        <a class="dropdown-item confirm-order"
                                                                            href="javascript:void(0)" data-id="{{ $order->id }}">Xác
                                                                            nhận</a>
                                                                    @endif
                                                                    <a class="dropdown-item" target="_blank" href="{{ route('admin.order-detail', ['id' => $order->id] ) }}">Xem chi
                                                                        tiết</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @foreach ($orders as $order)
                                            {{-- Modal Address --}}
                                            <div class="modal fade" id="addressShippingModal-{{ $order->id }}" tabindex="-1"
                                                aria-labelledby="addressShippingModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addressShippingModalLabel">Thông tin giao hàng đơn
                                                                #{{ $order->id }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Người nhận: {{ $order->shippingAddress ? $order->shippingAddress->full_name : 'N/A' }}</p>
                                                            <p>Địa chỉ: {{ $order->shippingAddress ? $order->shippingAddress->address : 'N/A' }}</p>
                                                            <p>Thành phố: {{ $order->shippingAddress ? $order->shippingAddress->city : 'N/A' }}</p>
                                                            <p>Số điện thoại: {{ $order->shippingAddress ? $order->shippingAddress->phone : 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Modal OrderItems --}}
                                            <div class="modal fade" id="orderItemsModal-{{ $order->id }}" tabindex="-1"
                                                aria-labelledby="orderItemsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="orderItemsModalLabel">
                                                                Chi tiết đơn hàng #{{ $order->id }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">

                                                            {{-- Bảng sản phẩm --}}
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Tên sản phẩm</th>
                                                                        <th>Số lượng</th>
                                                                        <th>Đơn giá</th>
                                                                        <th>Thành tiền</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $index = 1; @endphp
                                                                    @foreach ($order->orderItems as $item)
                                                                        <tr>
                                                                            <td>{{ $index++ }}</td>
                                                                            <td>{{ $item->product ? $item->product->name : 'Sản phẩm đã bị xóa' }}</td>
                                                                            <td>{{ $item->quantity }}</td>
                                                                            <td>{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                                                            <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }} ₫</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>

                                                            {{-- TÍNH TỔNG TIỀN --}}
                                                            @php
                                                                $total = $order->orderItems->sum(function ($i) {
                                                                    return $i->price * $i->quantity;
                                                                });
                                                                $shipping = 25000;
                                                                $finalTotal = $total + $shipping;
                                                            @endphp

                                                            <div style="margin-top: 20px; padding-top: 15px;">

                                                                <div style="display: flex; justify-content: right; margin-bottom: 8px; font-size: 15px;">
                                                                    <span style="margin-right: 10px">Tổng tiền sản phẩm:</span>
                                                                    <strong>{{ number_format($total, 0, ',', '.') }} ₫</strong>
                                                                </div>

                                                                <div style="display: flex; justify-content: right; margin-bottom: 8px; font-size: 15px;">
                                                                    <span style="margin-right: 10px">Phí vận chuyển:</span>
                                                                    <strong>{{ number_format($shipping, 0, ',', '.') }} ₫</strong>
                                                                </div>

                                                                <div class="totalPrice">
                                                                    <span style="font-weight: bold; margin-right: 10px;">Thành tiền:</span>
                                                                    <span style="font-weight: bold;">
                                                                        {{ number_format($finalTotal, 0, ',', '.') }} ₫
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->

@endsection

