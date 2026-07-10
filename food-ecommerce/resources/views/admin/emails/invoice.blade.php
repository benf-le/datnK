<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn mua hàng</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;">

    <div style="max-width:700px; margin:auto; background:#fff; padding:25px; border-radius:10px;">

        <!-- Header -->
        <h2 style="text-align:center; margin-bottom:5px; color:#28a745;">HÓA ĐƠN MUA HÀNG</h2>
        <p style="text-align:center; color:#777; margin-top:0;">
            Ngày tạo: {{ $order->created_at->format('d/m/Y H:i') }}
        </p>

        <!-- Greeting -->
        <p>Chào <strong>{{ $order->shippingAddress ? $order->shippingAddress->full_name : 'N/A' }}</strong>,</p>
        <p>Cảm ơn bạn đã mua hàng tại <strong>KFood</strong>. Dưới đây là thông tin đơn hàng của bạn.</p>

        <!-- From - To -->
        <table style="width:100%; margin:20px 0;">
            <tr>
                <td style="vertical-align:top; width:50%;">
                    <h3 style="margin-bottom:5px;">Từ</h3>
                    <p style="margin:0;">
                        <strong>{{ $order->shippingAddress ? $order->shippingAddress->full_name : 'N/A' }}</strong><br>
                        {{ $order->shippingAddress ? $order->shippingAddress->address : 'N/A' }}<br>
                        {{ $order->shippingAddress ? $order->shippingAddress->city : 'N/A' }}<br>
                        SĐT: {{ $order->shippingAddress ? $order->shippingAddress->phone : 'N/A' }}
                    </p>
                </td>
                <td style="vertical-align:top; width:50%;">
                    <h3 style="margin-bottom:5px;">Đến</h3>
                    <p style="margin:0;">
                        KFood<br>
                        470 Trần Đại Nghĩa, Ngũ Hành Sơn, Đà Nẵng<br>
                        SĐT: +84 386 823 982<br>
                        Email: khanhhq.21ad@vku.udn.vn
                    </p>
                </td>
            </tr>
        </table>

        <!-- Customer Info -->
        <h3>Thông tin khách hàng</h3>
        <p style="margin:0;">
            <strong>Mã đơn hàng:</strong> #{{ $order->id }}<br>
            <strong>Email:</strong> {{ $order->user ? $order->user->email : 'N/A' }}<br>
            <strong>Tài khoản:</strong> {{ $order->user ? $order->user->name : 'Tài khoản đã bị xóa' }}
        </p>

        <!-- Order Detail -->
        <h3 style="margin-top:25px;">Chi tiết đơn hàng</h3>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#28a745; color:#fff;">
                    <th style="padding:10px; text-align:left;">Ảnh</th>
                    <th style="padding:10px; text-align:left;">Sản phẩm</th>
                    <th style="padding:10px; text-align:right;">Giá</th>
                    <th style="padding:10px; text-align:center;">SL</th>
                    <th style="padding:10px; text-align:right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr style="border-bottom:1px solid #ddd;">
                        <td style="padding:10px;">
                            <img src="{{ $item->product ? $item->product->image_url : '#' }}" width="50" style="border-radius:5px;">
                        </td>
                        <td style="padding:10px;">{{ $item->product ? $item->product->name : 'Sản phẩm đã bị xóa' }}</td>
                        <td style="padding:10px; text-align:right;">
                            {{ number_format($item->price, 0, ',', '.') }} ₫
                        </td>
                        <td style="padding:10px; text-align:center;">
                            {{ $item->quantity }}
                        </td>
                        <td style="padding:10px; text-align:right;">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Payment Method -->
        <h3 style="margin-top:25px;">Phương thức thanh toán</h3>
        <p style="
            padding:10px; 
            text-align:center; 
            border-radius:5px;
            color:#fff;
            background: {{ ($order->payment && $order->payment->payment_method == 'paypal') ? '#0070ba' : '#28a745' }};
        ">
            {{ ($order->payment && $order->payment->payment_method == 'paypal') ? 'Thanh toán PayPal' : 'Thanh toán khi nhận hàng' }}
        </p>

        <!-- Summary -->
        <h3 style="margin-top:25px;">Tổng kết thanh toán</h3>
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="padding:10px;">Tiền hàng:</td>
                <td style="padding:10px; text-align:right;">
                    {{ number_format($order->total_price - 25000, 0, ',', '.') }} ₫
                </td>
            </tr>
            <tr>
                <td style="padding:10px;">Shipping:</td>
                <td style="padding:10px; text-align:right;">
                    {{ number_format(25000, 0, ',', '.') }} ₫
                </td>
            </tr>
            <tr style="background:#28a745; color:#fff;">
                <td style="padding:10px;"><strong>Tổng cộng:</strong></td>
                <td style="padding:10px; text-align:right;">
                    <strong>{{ number_format($order->total_price, 0, ',', '.') }} ₫</strong>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <p style="text-align:center; font-size:14px; color:#777; margin-top:40px;">
            Cảm ơn bạn đã mua hàng tại KFood! ❤️
        </p>

    </div>

</body>

</html>