<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <title>
        @if (isset($title))
            {{ $title }} - {{ config('app.name', 'Laravel') }}
        @else
            {{ config('app.name', 'Laravel') }}
        @endif
        
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="{{ config('app.name') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{-- Add SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('adminsrc/assets/images/favicon.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- Datatables css -->
    <link href="{{ asset('adminsrc/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('adminsrc/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('adminsrc/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('adminsrc/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('adminsrc/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('adminsrc/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('adminsrc/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    @stack('styles')

</head>

<!-- body start -->

<body data-menu-color="dark" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">


        <!-- Topbar Start -->
        @include('admin.layouts.partials.navbar')
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        @include('admin.layouts.partials.sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-xxl">

                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="m-0 fs-18 fw-semibold">{{ $title }}</h4>
                        </div>

                        <div class="text-end">
                            <ol class="py-0 m-0 breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>

                    {{ $slot }}
                </div> <!-- container-fluid -->

            </div> <!-- content -->

            <!-- Footer Start -->
            @include('admin.layouts.partials.footer')
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <!-- Vendor JS -->
    <script src="{{ asset('adminsrc/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- Datatables JS -->
    <script src="{{ asset('adminsrc/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('adminsrc/assets/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js') }}"></script>

    <!-- Datatable Initialization -->
    <script src="{{ asset('adminsrc/assets/js/pages/datatable.init.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('adminsrc/assets/js/app.js') }}"></script>

    <!-- SweetAlert2 JS -->
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
