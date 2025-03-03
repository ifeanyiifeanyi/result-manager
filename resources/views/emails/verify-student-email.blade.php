<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #e6e6e6;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .content {
            padding: 30px 20px;
        }
        h1 {
            color: #4a5568;
            font-size: 24px;
            margin-top: 0;
        }
        p {
            margin-bottom: 20px;
            color: #4a5568;
        }
        .button {
            display: inline-block;
            background-color: #4299e1;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            color: #718096;
            font-size: 14px;
            border-top: 1px solid #e6e6e6;
        }
        .details {
            background-color: #f5f7fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .verification-code {
            letter-spacing: 2px;
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            color: #4a5568;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Replace with your school logo -->
            <h2>Student Portal</h2>
        </div>

        <div class="content">
            <h1>Verify Your Email Address</h1>

            <p>Hello {{ $student->first_name }},</p>

            <p>Thank you for creating an account with us! To complete your registration, please verify your email address by clicking the button below:</p>

            <div style="text-align: center;">
                <a href="{{ $student->getVerificationUrl() }}" class="button">Verify Email Address</a>
            </div>

            <p>This verification link will expire in 60 minutes.</p>

            <p>If you're having trouble clicking the button, copy and paste the following URL into your browser:</p>

            <div class="details">
                <p style="word-break: break-all; margin: 0;">{{ $student->getVerificationUrl() }}</p>
            </div>

            <p>If you did not create an account, no further action is required.</p>

            <p>Regards,<br>Student Management Team</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Student Portal. All rights reserved.</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>