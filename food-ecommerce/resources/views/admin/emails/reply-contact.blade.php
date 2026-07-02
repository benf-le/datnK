<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phản hồi liên hệ</title>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 25px;
        }

        .email-wrapper {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 14px;
            padding: 0;
            box-shadow: 0 6px 24px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #e5e9f2;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #2C7BE5, #4C9CFF);
            padding: 25px 30px;
            color: #fff;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        /* Message Content */
        .content {
            padding: 30px;
        }

        .message-box {
            background: #f9fbff;
            border-left: 5px solid #2C7BE5;
            padding: 18px 20px;
            border-radius: 8px;
            color: #333;
            font-size: 16px;
            line-height: 1.7;
            white-space: pre-line;
        }

        /* Divider line */
        .divider {
            width: 100%;
            height: 1px;
            background: #e5e9f2;
            margin: 25px 0;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px 30px 30px;
            font-size: 13px;
            color: #777;
        }

        .footer b {
            color: #2C7BE5;
        }
    </style>
</head>

<body>

    <div class="email-wrapper">

        <div class="header">
            <h1>Phản hồi từ Quản trị viên KFood</h1>
        </div>

        <div class="content">

            <div class="message-box">
                {!! $messageContent !!}
            </div>

            <div class="divider"></div>

        </div>

        <div class="footer">
            Trân trọng,<br>
            <b>KFood Support Team</b><br>
            Cần hỗ trợ thêm? Hãy liên hệ với chúng tôi bất cứ lúc nào.
        </div>

    </div>

</body>
</html>
