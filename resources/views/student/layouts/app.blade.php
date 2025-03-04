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
            <div class="row gy-4">
                <div class="col-lg-9">
                    <!-- Grettings Box Start -->
                    <div
                        class="overflow-hidden flex-wrap gap-16 grettings-box position-relative rounded-16 bg-main-600 z-1">
                        <img src="/studentsrc/assets/images/bg/grettings-pattern.png" alt=""
                            class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                        <div class="row gy-4">
                            <div class="col-sm-7">
                                <div class="grettings-box__content py-xl-4">
                                    <h2 class="mb-0 text-white">Hello, {{ Str::title($user->first_name) }}! </h2>
                                    <p class="mt-4 text-white text-15 fw-light">Let’s learning something today</p>
                                    <p class="mt-24 text-lg text-white fw-light">Set your study plan and growth with
                                        community</p>
                                </div>
                            </div>
                            <div class="col-sm-5 d-sm-block d-none">
                                <div class="text-center h-100 d-flex justify-content-center align-items-end">
                                    <img src="/studentsrc/assets/images/thumbs/gretting-img.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Grettings Box End -->


                </div>
                <div class="col-lg-3">

                    <!-- Calendar Start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="calendar">
                                <div class="calendar__header">
                                    <button type="button" class="calendar__arrow left"><i
                                            class="ph ph-caret-left"></i></button>
                                    <p class="mb-0 display h6">""</p>
                                    <button type="button" class="calendar__arrow right"><i
                                            class="ph ph-caret-right"></i></button>
                                </div>

                                <div class="calendar__week week">
                                    <div class="calendar__week-text">Su</div>
                                    <div class="calendar__week-text">Mo</div>
                                    <div class="calendar__week-text">Tu</div>
                                    <div class="calendar__week-text">We</div>
                                    <div class="calendar__week-text">Th</div>
                                    <div class="calendar__week-text">Fr</div>
                                    <div class="calendar__week-text">Sa</div>
                                </div>
                                <div class="days"></div>
                            </div>


                        </div>
                    </div>
                    <!-- Calendar End -->



                </div>
            </div>
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


@stack('scripts')
</body>

</html>
