<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | {{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0038ff;
            --dark-blue: #001c80;
            --light-purple: #a4adff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: url({{ asset('bg.jpg') }});
            background-size: cover !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            height: 100vh !important;
            position: relative !important;

        }

        .logo-container {
            text-align: center;
            padding: 15px 0;
        }

        .logo-text {
            color: #ff9900;
            font-size: 2rem;
            font-weight: bold;
            margin-left: 10px;
        }

        .logo-icon {
            color: #ff9900;
            font-size: 2rem;
        }

        .card-container {
            max-width: 1200px;
            margin: 1rem auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .left-side {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            position: relative;
            padding: 0;
            overflow: hidden;
            min-height: 600px;
        }

        .left-bg-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .bg-square {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            transform: rotate(45deg);
        }

        .bg-square-1 {
            width: 100px;
            height: 100px;
            bottom: 10%;
            left: 5%;
        }

        .bg-square-2 {
            width: 80px;
            height: 80px;
            top: 15%;
            right: 10%;
        }

        .school-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 2rem;
            color: white;
            text-align: center;
        }

        .school-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .school-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            max-width: 80%;
        }

        .student-images {
            position: relative;
            margin-top: 2rem;
            width: 320px;
            height: 320px;
        }

        .student-image {
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 20px solid white;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .image-label {
            position: absolute;
            z-index: 2;
            /* border-radius: 20px; */
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            animation: float 3s ease-in-out infinite;
        }

        .label-top {
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .label-left {
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
        }

        .label-right {
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .label-top {
            animation: floatTop 3s ease-in-out infinite;
        }

        .label-left {
            animation: floatLeft 3s ease-in-out infinite;
            animation-delay: 0.5s;
        }

        .label-right {
            animation: floatRight 3s ease-in-out infinite;
            animation-delay: 1s;
        }

        @keyframes floatTop {
            0% {
                transform: translateX(-50%) translateY(0);
            }
            50% {
                transform: translateX(-50%) translateY(-5px);
            }
            100% {
                transform: translateX(-50%) translateY(0);
            }
        }

        @keyframes floatLeft {
            0% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(-5px);
            }
            100% {
                transform: translateY(-50%) translateX(0);
            }
        }

        @keyframes floatRight {
            0% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(5px);
            }
            100% {
                transform: translateY(-50%) translateX(0);
            }
        }

        .admin-logo {
            position: absolute;
            bottom: 50px;
            left: 50px;
            color: white;
            z-index: 2;
        }

        .right-side {
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            min-height: 600px;
        }

        .login-container {
            max-width: 400px;
            margin: 0 auto;
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .login-form {
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: #666;
        }

        .form-control {
            padding: 0.8rem 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
        }

        .btn-login {
            background-color: var(--light-purple);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.8rem;
            font-weight: 500;
            width: 100%;
            margin-top: 1.5rem;
        }

        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password a {
            color: #40a9ff;
            text-decoration: none;
        }

        .signup-link {
            text-align: center;
            margin-top: 1rem;
        }

        .signup-link a {
            color: #40a9ff;
            text-decoration: none;
            font-weight: 500;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        @media (max-width: 992px) {
            .card-container {
                margin: 0;
                max-width: 100%;
                border-radius: 0;
                box-shadow: none;
            }

            .left-side {
                display: none;
            }

            .right-side {
                padding: 2rem;
                min-height: auto;
            }
        }
    </style>

</head>

<body>
    <div class="p-0 container-fluid">
        {{-- <div class="logo-container">
            <span class="logo-icon"><i class="fas fa-lightbulb"></i></span>
            <span class="logo-text">Brightfield Academy</span>
        </div> --}}

        <div class="container">
            <div class="row card-container">
                <div class="p-0 col-lg-7 left-side">
                    <div class="left-bg-elements">
                        <div class="bg-square bg-square-1"></div>
                        <div class="bg-square bg-square-2"></div>
                    </div>

                    <div class="school-content">
                        <h1 class="school-title">Brightfield Academy</h1>
                        <p class="school-description">
                            Empowering minds and shaping futures since 1995. Our institution is committed to academic
                            excellence</p>

                        <div class="student-images">
                            <span class="p-3 badge bg-light text-primary me-2 image-label label-top">Academic Excellence</span>
                            <span class="p-3 badge bg-light text-primary me-2 image-label label-left">Innovation</span>
                            <span class="p-3 badge bg-light text-primary image-label label-right">Leadership</span>
                            <img src="{{ asset('IMG04846_(2).jpg') }}" alt="Student 3" class="student-image">
                        </div>

                    </div>

                    <div class="admin-logo">
                        <i class="fas fa-lightbulb me-2"></i>
                        <span class="fs-4 fw-bold">School Admin</span>
                    </div>
                </div>

                <div class="p-0 col-lg-5 right-side">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>
