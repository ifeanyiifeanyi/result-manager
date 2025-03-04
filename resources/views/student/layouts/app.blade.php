<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>
        @if (isset($title))
            {{ $title }} - {{ config('app.name', 'Laravel') }}
        @else
            {{ config('app.name', 'Laravel') }}
        @endif
    </title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('studentsrc/assets/images/logo/favicon.png') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/bootstrap.min.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/file-upload.css') }}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/plyr.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <!-- full calendar -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/full-calendar.css') }}">
    <!-- jquery Ui -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/jquery-ui.css') }}">
    <!-- editor quill Ui -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/editor-quill.css') }}">
    <!-- apex charts Css -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/apexcharts.css') }}">
    <!-- calendar Css -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/calendar.css') }}">
    <!-- jvector map Css -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/jquery-jvectormap-2.0.5.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('studentsrc/assets/css/main.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    
    {{-- Add SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .active {
            color: #4a98f5 !important;
            background: #e9f3fe !important;

        }
    </style>
    @stack('styles')
</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->


    <!-- ============================ Sidebar Start ============================ -->

    @include('student.layouts.partial.sidebar')
    <!-- ============================ Sidebar End  ============================ -->


    <div class="dashboard-main-wrapper">

        @include('student.layouts.partial.navbar')


        <div class="dashboard-body">

            {{ $slot }}

        </div>

        @include('student.layouts.partial.footer')
    </div>

    <!-- Jquery js -->
    <script src="{{ asset('studentsrc/assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('studentsrc/assets/js/boostrap.bundle.min.js') }}"></script>
    <!-- Phosphor Js -->
    <script src="{{ asset('studentsrc/assets/js/phosphor-icon.js') }}"></script>
    <!-- file upload -->
    <script src="{{ asset('studentsrc/assets/js/file-upload.js') }}"></script>
    <!-- file upload -->
    <script src="{{ asset('studentsrc/assets/js/plyr.js') }}"></script>
    <!-- dataTables -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <!-- full calendar -->
    <script src="{{ asset('studentsrc/assets/js/full-calendar.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('studentsrc/assets/js/jquery-ui.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('studentsrc/assets/js/editor-quill.js') }}"></script>
    <!-- apex charts -->
    <script src="{{ asset('studentsrc/assets/js/apexcharts.min.js') }}"></script>
    <!-- Calendar Js -->
    <script src="{{ asset('studentsrc/assets/js/calendar.js') }}"></script>
    <!-- jvectormap Js -->
    <script src="{{ asset('studentsrc/assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <!-- jvectormap world Js -->
    <script src="{{ asset('studentsrc/assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- main js -->
    <script src="{{ asset('studentsrc/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Success Message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Error Message
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Warning Message
        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: "{{ session('warning') }}",
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Handle Validation Errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: "{!! implode('\n', $errors->all()) !!}",
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Handle Exception
        @if (session('exception'))
            Swal.fire({
                icon: 'error',
                title: 'Exception Occurred!',
                text: "{{ session('exception') }}",
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>

    @stack('scripts')
</body>

</html>
