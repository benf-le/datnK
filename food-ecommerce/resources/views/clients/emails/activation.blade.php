<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kích hoạt tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #2c7a7b;
        }
        a.button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #28a745;
            color: #fff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 15px;
        }
        a.button:hover {
            background-color: #218838;
        }
        p {
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Xin chào, {{ $user->name }}</h1>
        <p>Cảm ơn bạn đã đăng ký tại website của chúng tôi.</p>
        <p>Để kích hoạt tài khoản của bạn, vui lòng nhấp vào liên kết dưới đây:</p>

        <a href="{{ url('/activate/'.$token) }}" class="button">Kích hoạt tài khoản</a>

        <p class="footer">
            Trân trọng,<br>
            Đội ngũ hỗ trợ khách hàng
        </p>
    </div>
</body>
</html>
