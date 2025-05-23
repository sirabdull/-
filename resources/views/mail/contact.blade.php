<!DOCTYPE html>
<html>

<head>
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }

        h2 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        h3 {
            color: #444;
        }

        .message-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }

        .footer {
            margin-top: 30px;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <h2>New Contact Form Submission</h2>

    <p><strong>Name:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Phone:</strong> {{ $phone }}</p>

    <div class="message-box">
        <h3>Message:</h3>
        <p>{{ $content }}</p>
    </div>

    <div class="footer">
        <p>This is an automated email from your website's contact form.</p>
    </div>
</body>

</html>
