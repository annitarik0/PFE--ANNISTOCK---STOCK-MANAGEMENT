<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ config('app.name', 'AnniStock') }} - @yield('title', 'Dashboard')</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesdesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App Icons -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/img2.jpg.png') }}">

    <!-- App css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Toastr css -->
    <link href="{{ asset('backend/assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <style>
        .content-page {
            margin-left: 240px;
            overflow: hidden;
            padding: 0 15px 65px 15px;
            min-height: 80vh;
            margin-top: 70px;
            transition: all 0.3s ease;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
            padding: 18px 22px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-weight: 600;
        }

        .card-body {
            padding: 22px;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(46, 89, 217, 0.2);
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            padding: 12px 15px;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            letter-spacing: 0.3px;
        }

        /* Improved loading spinner */
        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
            border-width: 0.2em;
        }

        /* Improved form controls */
        .form-control {
            padding: 10px 15px;
            height: auto;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }

        @media (max-width: 992px) {
            .content-page {
                margin-left: 0;
                padding: 0 12px 65px 12px;
            }

            .card {
                margin-bottom: 20px;
            }

            .card-header {
                padding: 15px 18px;
            }

            .card-body {
                padding: 18px;
            }
        }


    </style>

    @yield('styles')
</head>

<body>
    <div id="wrapper">
        @include('header-dash')

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('footer-dash')
    </div>

    <!-- jQuery  -->
    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('backend/assets/js/waves.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Toastr js -->
    <script src="{{ asset('backend/assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('.datatable').DataTable();

            // Initialize Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Display flash messages
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if(session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            @if(session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif
        });
    </script>

    @yield('scripts')
</body>
</html>
