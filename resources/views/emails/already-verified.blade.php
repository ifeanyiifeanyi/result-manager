<!-- resources/views/auth/verification/already-verified.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Verified</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verification-container {
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .info-icon {
            width: 80px;
            height: 80px;
            background-color: #4299e1;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        h1 {
            color: #2d3748;
            margin-bottom: 20px;
        }

        p {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .cta-button {
            display: inline-block;
            background-color: #4299e1;
            color: white !important;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #3182ce;
            text-decoration: none;
        }
    </style>
</head>
<!-- resources/views/auth/verification/already-verified.blade.php (completion) -->

<body>
    <div class="verification-container">
        <div class="info-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1>Email Already Verified</h1>
        <p>Your email address has already been verified.</p>
        <p>You can proceed to login to access your student portal.</p>

        <a href="{{ route('login') }}" class="cta-button">Go to Login</a>
    </div>
</body>

</html>
