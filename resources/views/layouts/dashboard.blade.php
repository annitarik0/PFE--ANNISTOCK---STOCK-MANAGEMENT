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
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

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
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
            padding: 15px 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 4px;
        }
        
        @media (max-width: 768px) {
            .content-page {
                margin-left: 0;
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
