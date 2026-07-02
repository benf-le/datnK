@extends('layouts.client')

@section('title', 'Tài khoản')
@section('breadcrumb', 'Tài khoản')

@section('content')

    <!-- WISHLIST AREA START -->
    <div class="liton__wishlist-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- PRODUCT TAB AREA START -->
                    <div class="ltn__product-tab-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="ltn__tab-menu-list mb-50">
                                        <div class="nav">
                                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_dashboard">Bảng
                                                điều khiển <i class="fas fa-home"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_orders">Đơn hàng <i
                                                    class="fas fa-file-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_address">Địa chỉ <i
                                                    class="fas fa-map-marker-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_account">Chi tiết tài khoản <i
                                                    class="fas fa-user"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_password">Đổi mật khẩu <i
                                                    class="fas fa-user"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="liton_tab_dashboard">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Chào mừng bạn <strong>{{ $user->email }}</strong> quay lại! <br>
                                                    Nếu đây không phải là bạn, hãy <small><a
                                                            href="{{ route('logout') }}"><b><u><i>đăng
                                                                        xuất</i></u></b></a></small> nhé.
                                                </p>
                                                <p>Chào mừng bạn quay lại với KFood! Tại đây, bạn có thể xem lại <span>đơn
                                                        hàng gần đây</span>,
                                                    quản lý <span>địa chỉ giao hàng và thanh toán</span>,
                                                    hoặc <span>chỉnh sửa thông tin tài khoản và mật khẩu</span> của mình
                                                    thật dễ dàng.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_orders">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="table-responsive" style="overflow-x: auto; overflow-y: scroll; max-height: 400px">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Đơn hàng</th>
                                                                <th>Ngày đặt</th>
                                                                <th>Trạng thái</th>
                                                                <th>Tổng tiền</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orders as $order)
                                                                <tr>
                                                                    <td>#{{ $order->id }}</td>
                                                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                                    <td>
                                                                        @if ($order->status == 'pending')
                                                                            <span class="badge bg-warning" style="width: 120px">Chờ xác nhận</span>
                                                                        @elseif ($order->status == 'processing')
                                                                            <span class="badge bg-primary" style="width: 120px">Đang giao hàng</span>
                                                                        @elseif ($order->status == 'completed')
                                                                            <span class="badge bg-success" style="width: 120px">Hoàn thành</span>
                                                                        @elseif ($order->status == 'canceled')
                                                                            <span class="badge bg-danger" style="width: 120px">Đã hủy</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                                                                    <td><a href="{{route('order.show', $order->id)}}" class="btn btn-sm btn-info">Xem chi tiết</a></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_address">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Địa chỉ này sẽ được dùng tự động khi bạn thanh toán.</p>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Tên người nhận</th>
                                                                <th>Địa chỉ</th>
                                                                <th>Thành phố</th>
                                                                <th>Số điện thoại</th>
                                                                <th>Mặc định</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($addresses as $address)
                                                                <tr>
                                                                    <td>{{ $address->full_name }}</td>
                                                                    <td>{{ $address->address }}</td>
                                                                    <td>{{ $address->city }}</td>
                                                                    <td>{{ $address->phone }}</td>
                                                                    <td>
                                                                        @if ($address->is_default)
                                                                            <span class="badge bg-success">Mặc định</span>
                                                                        @else
                                                                            <form action="{{ route('account.addresses.update', $address->id) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <button class="btn btn-effect-1 btn-warning">Chọn</button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <form action="{{ route('account.addresses.delete', $address->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                            onclick="return confirm('Bạn chắc chắn muốn xóa địa chỉ này?')">Xóa</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn theme-btn-1 btn-effect-1 mt-3" data-bs-toggle="modal"
                                                    data-bs-target="#addAddressModal">Thêm địa chỉ mới</button>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="addAddressModal" tabindex="-1"
                                            aria-labelledby="addAddressModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="padding: 10px 10px">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('account.addresses.add') }}" method="POST"
                                                            id="addAddressForm">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="full_name" class="form-label">Tên người
                                                                    dùng</label>
                                                                <input type="text" class="form-control" id="full_name"
                                                                    name="full_name" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="address" class="form-label">Địa chỉ</label>
                                                                <input type="text" class="form-control" id="address"
                                                                    name="address" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="city" class="form-label">Thành phố</label>
                                                                <input type="text" class="form-control" id="city"
                                                                    name="city" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone" class="form-label">Số điện thoại</label>
                                                                <input type="text" class="form-control" id="phone"
                                                                    name="phone" required>
                                                            </div>
                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox" class="form-check-input" id="is_default"
                                                                    name="is_default">
                                                                <label for="is_default" class="form-label">Đặt làm địa chỉ mặc
                                                                    định</label>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn theme-btn-1 btn-effect-1 mt-3">Lưu địa
                                                                chỉ</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_account">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="ltn__form-box">
                                                    <form action="{{ route('account.update') }}" method="POST"
                                                        id="update-account" enctype="multipart/form-data">

                                                        @method('PUT')

                                                        <div class="row mb-50">
                                                            <div class="col-md-12 text-center mb-3">
                                                                <div class="profile-pic-container">
                                                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                                                        alt="Avatar" id="preview-image" class="profile-pic">
                                                                    <input type="file" name="avatar" id="avatar"
                                                                        accept="image/*" class="d-none">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="ltn__name">Họ và tên:</label>
                                                                <input type="text" name="ltn__name" id="ltn__name"
                                                                    value="{{ $user->name }}" required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="ltn__phone_number">Số điện thoại:</label>
                                                                <input type="number" name="ltn__phone_number"
                                                                    id="ltn__phone_number" value="{{ $user->phone_number }}"
                                                                    required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="ltn__email">Email (không thể thay đổi)</label>
                                                                <input type="text" name="ltn__email" id="ltn__email"
                                                                    value="{{ $user->email }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                class="btn theme-btn-1 btn-effect-1 text-uppercase">Cập
                                                                nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_password">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="ltn__form-box">
                                                    <form action="{{ route('account.change-password') }}" method="POST"
                                                        id="change-password-form">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Mật khẩu hiện tại:</label>
                                                                    <input type="password" name="current_password" required>
                                                                    <label>Mật khẩu mới:</label>
                                                                    <input type="password" name="new_password" required>
                                                                    <label>Xác nhận mật khẩu mới:</label>
                                                                    <input type="password" name="confirm_new_password"
                                                                        autocomplete="new-password" required>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                class="btn theme-btn-1 btn-effect-1 text-uppercase">Đổi mật
                                                                khẩu</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PRODUCT TAB AREA END -->
                </div>
            </div>
        </div>
    </div>
    <!-- WISHLIST AREA START -->

@endsection