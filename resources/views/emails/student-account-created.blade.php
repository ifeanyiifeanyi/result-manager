<!-- resources/views/emails/student-account-created.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isPasswordReset ? 'Your Password Has Been Reset' : 'Your Student Account Details' }}</title>
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
        .credentials {
            margin: 10px 0;
        }
        .credentials span {
            font-weight: bold;
        }
        .password {
            letter-spacing: 2px;
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            color: #4a5568;
        }
        .warning {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 15px;
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
            <h1>{{ $isPasswordReset ? 'Your Password Has Been Reset' : 'Welcome to Student Portal' }}</h1>

            <p>Hello {{ $student->first_name }},</p>

            @if($isPasswordReset)
                <p>Your password has been reset. Please use the following credentials to log in:</p>
            @else
                <p>Your student account has been created successfully. You can now log in to the Student Portal using the following credentials:</p>
            @endif

            <div class="details">
                <div class="credentials">
                    <span>Username:</span> {{ $student->username }}
                </div>
                <div class="credentials">
                    <span>Email:</span> {{ $student->email }}
                </div>
                <div class="credentials">
                    <span>Password:</span> <span class="password">{{ $password }}</span>
                </div>

                <p class="warning">Please change your password after your first login for security reasons.</p>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button">Go to Login Page</a>
            </div>

            @if(!$student->hasVerifiedEmail())
                <p>To verify your email address, please check your inbox for a verification email or click the button below:</p>

                <div style="text-align: center;">
                    <a href="{{ $student->getVerificationUrl() }}" class="button">Verify Email Address</a>
                </div>
            @endif

            <p>If you have any questions or need assistance, please contact our support team.</p>

            <p>Regards,<br>Student Management Team</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Student Portal. All rights reserved.</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>