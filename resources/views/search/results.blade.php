<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Search Results</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/dashboard.css')}}" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="{{asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <style>
            .search-section-title {
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
                margin-bottom: 15px;
                font-weight: 600;
                color: #333;
            }

            .card {
                border-radius: 4px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                margin-bottom: 20px;
            }

            .card:hover {
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }

            .search-again {
                background-color: #f8f9fa;
                padding: 15px;
                border-radius: 4px;
                margin-bottom: 20px;
            }

            .badge {
                padding: 5px 10px;
                font-weight: 500;
            }

            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
            }

            .mdi {
                font-size: 18px;
                vertical-align: middle;
                margin-right: 5px;
            }
        </style>
    </head>

    <body>
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                </div>
            </div>
        </div>

        @include('header-dash')

        <!-- Page content -->
        <div class="wrapper">
            <div class="container-fluid">
                <!-- Page title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="page-title m-0">Search Results</h4>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right d-none d-md-block">
                                        <div class="dropdown">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                                <li class="breadcrumb-item active">Search Results</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search results -->
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Search Results for "{{ $query }}"</h4>
                                <p class="text-muted m-b-30">Found {{ $totalResults }} results</p>

                                @if(!Auth::check() || !Auth::user()->isAdmin())
                                    <div class="alert alert-info mb-4">
                                        <i class="mdi mdi-information-outline mr-2"></i>
                                        Note: As an employee, your search results are limited to products and orders only.
                                    </div>
                                @endif

                                <div class="search-again mb-4">
                                    <form action="{{ route('search') }}" method="GET">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="mdi mdi-magnify"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="query" class="form-control form-control-lg" value="{{ $query }}" placeholder="Search again..." autocomplete="off" id="dynamic-search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="mdi mdi-magnify"></i> Search```php
<!-- Search results -->
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Search Results for "{{ $query }}"</h4>
                <p class="text-muted m-b-30">Found {{ $totalResults }} results</p>

                @if(!Auth::check() || !Auth::user()->isAdmin())
                    <div class="alert alert-info mb-4">
                        <i class="mdi mdi-information-outline mr-2"></i>
                        Note: As an employee, your search results are limited to products and orders only.
                    </div>
                @endif

                <div class="search-again mb-4">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                            </div>
                            <input type="text" name="query" class="form-control form-control-lg" value="{{ $query }}" placeholder="Search again..." autocomplete="off" id="dynamic-search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="mdi mdi-magnify"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    // Add animation to search input when focused
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchInput = document.getElementById('dynamic-search');

                        searchInput.addEventListener('focus', function() {
                            this.parentElement.classList.add('shadow-lg');
                            this.parentElement.style.transition = 'all 0.3s ease';
                        });

                        searchInput.addEventListener('blur', function() {
                            this.parentElement.classList.remove('shadow-lg');
                        });

                        // Add auto-complete effect
                        let typingTimer;
                        searchInput.addEventListener('keyup', function() {
                            clearTimeout(typingTimer);
                            if (this.value) {
                                typingTimer = setTimeout(function() {
                                    // Simulate auto-complete by adding a subtle pulse animation
                                    searchInput.classList.add('pulse-animation');
                                    setTimeout(function() {
                                        searchInput.classList.remove('pulse-animation');
                                    }, 500);
                                }, 500);
                            }
                        });
                    });
                </script>

                <style>
                    .input-group {
                        border-radius: 4px;
                        overflow: hidden;
                    }

                    .input-group-text {
                        border: none;
                    }

                    .form-control-lg {
                        border: none;
                        box-shadow: none;
                        font-size: 16px;
                    }

                    .form-control-lg:focus {
                        box-shadow: none;
                    }

                    .btn-lg {
                        padding: 10px 20px;
                    }

                    .pulse-animation {
                        animation: pulse 0.5s;
                    }

                    @keyframes pulse {
                        0% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.4); }
                        70% { box-shadow: 0 0 0 10px rgba(78, 115, 223, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
                    }
                </style>

                @if($totalResults == 0)
                    <div class="alert alert-info">
                        No results found for "{{ $query }}". Please try a different search term.
                    </div>
                @else
                    <!-- Products Section -->
                    @if(count($results['products']) > 0)
                        <div class="search-section mb-4">
                            <h5 class="search-section-title">
                                <i class="mdi mdi-package-variant mr-2 text-primary"></i>Products
                            </h5>
                            <div class="row">
                                @foreach($results['products'] as $product)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">{{ $product->category ? $product->category->name : 'No Category' }}</h6>
                                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge badge-primary">{{ $product->price }}</span>
                                                    <div>
                                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info waves-effect waves-light">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                        @if(Auth::check() && Auth::user()->isAdmin())
                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary waves-effect waves-light">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Categories Section (Admin Only) -->
                    @if(Auth::check() && Auth::user()->isAdmin() && count($results['categories']) > 0)
                        <div class="search-section mb-4">
                            <h5 class="search-section-title">
                                <i class="mdi mdi-tag-multiple mr-2 text-success"></i>Categories
                            </h5>
                            <div class="row">
                                @foreach($results['categories'] as $category)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $category->name }}</h5>
                                                <p class="card-text">{{ $category->description ? Str::limit($category->description, 100) : 'No description available' }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge badge-success">{{ method_exists($category, 'products') ? $category->products->count() : '0' }} products</span>
                                                    <div>
                                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info waves-effect waves-light">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary waves-effect waves-light">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Orders Section -->
                    @if(count($results['orders']) > 0)
                        <div class="search-section mb-4">
                            <h5 class="search-section-title">
                                <i class="mdi mdi-clipboard-text mr-2 text-danger"></i>Orders
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['orders'] as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    @if($order->status == 'completed')
                                                        <span class="badge badge-success">Completed</span>
                                                    @elseif($order->status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($order->status == 'cancelled')
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    @else
                                                        <span class="badge badge-info">{{ $order->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $order->total }}</td>
                                                <td>
                                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info waves-effect waves-light">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    @if(Auth::check() && Auth::user()->isAdmin())
                                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary waves-effect waves-light">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Users Section (Admin Only) -->
                    @if(Auth::check() && Auth::user()->isAdmin() && count($results['users']) > 0)
                        <div class="search-section mb-4">
                            <h5 class="search-section-title">
                                <i class="mdi mdi-account mr-2 text-warning"></i>Users
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <script>
                                    // Add animation to search input when focused
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const searchInput = document.getElementById('dynamic-search');

                                        searchInput.addEventListener('focus', function() {
                                            this.parentElement.classList.add('shadow-lg');
                                            this.parentElement.style.transition = 'all 0.3s ease';
                                        });

                                        searchInput.addEventListener('blur', function() {
                                            this.parentElement.classList.remove('shadow-lg');
                                        });

                                        // Add auto-complete effect
                                        let typingTimer;
                                        searchInput.addEventListener('keyup', function() {
                                            clearTimeout(typingTimer);
                                            if (this.value) {
                                                typingTimer = setTimeout(function() {
                                                    // Simulate auto-complete by adding a subtle pulse animation
                                                    searchInput.classList.add('pulse-animation');
                                                    setTimeout(function() {
                                                        searchInput.classList.remove('pulse-animation');
                                                    }, 500);
                                                }, 500);
                                            }
                                        });
                                    });
                                </script>

                                <style>
                                    .input-group {
                                        border-radius: 4px;
                                        overflow: hidden;
                                    }

                                    .input-group-text {
                                        border: none;
                                    }

                                    .form-control-lg {
                                        border: none;
                                        box-shadow: none;
                                        font-size: 16px;
                                    }

                                    .form-control-lg:focus {
                                        box-shadow: none;
                                    }

                                    .btn-lg {
                                        padding: 10px 20px;
                                    }

                                    .pulse-animation {
                                        animation: pulse 0.5s;
                                    }

                                    @keyframes pulse {
                                        0% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.4); }
                                        70% { box-shadow: 0 0 0 10px rgba(78, 115, 223, 0); }
                                        100% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
                                    }
                                </style>

                                @if($totalResults == 0)
                                    <div class="alert alert-info">
                                        No results found for "{{ $query }}". Please try a different search term.
                                    </div>
                                @else
                                    <!-- Products Section -->
                                    @if(count($results['products']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <i class="mdi mdi-package-variant mr-2 text-primary"></i>Products
                                            </h5>
                                            <div class="row">
                                                @foreach($results['products'] as $product)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card h-100">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                                <h6 class="card-subtitle mb-2 text-muted">{{ $product->category ? $product->category->name : 'No Category' }}</h6>
                                                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="badge badge-primary">{{ $product->price }}</span>
                                                                    <div>
                                                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info waves-effect waves-light">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>
                                                                        @if(Auth::check() && Auth::user()->isAdmin())
                                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary waves-effect waves-light">
                                                                            <i class="mdi mdi-pencil"></i>
                                                                        </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Categories Section (Admin Only) -->
                                    @if(Auth::check() && Auth::user()->isAdmin() && count($results['categories']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <i class="mdi mdi-tag-multiple mr-2 text-success"></i>Categories
                                            </h5>
                                            <div class="row">
                                                @foreach($results['categories'] as $category)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card h-100">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $category->name }}</h5>
                                                                <p class="card-text">{{ $category->description ? Str::limit($category->description, 100) : 'No description available' }}</p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="badge badge-success">{{ method_exists($category, 'products') ? $category->products->count() : '0' }} products</span>
                                                                    <div>
                                                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info waves-effect waves-light">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary waves-effect waves-light">
                                                                            <i class="mdi mdi-pencil"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Orders Section -->
                                    @if(count($results['orders']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <i class="mdi mdi-clipboard-text mr-2 text-danger"></i>Orders
                                            </h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Order #</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($results['orders'] as $order)
                                                            <tr>
                                                                <td>{{ $order->id }}</td>
                                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                                <td>
                                                                    @if($order->status == 'completed')
                                                                        <span class="badge badge-success">Completed</span>
                                                                    @elseif($order->status == 'pending')
                                                                        <span class="badge badge-warning">Pending</span>
                                                                    @elseif($order->status == 'cancelled')
                                                                        <span class="badge badge-danger">Cancelled</span>
                                                                    @else
                                                                        <span class="badge badge-info">{{ $order->status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $order->total }}</td>
                                                                <td>
                                                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info waves-effect waves-light">
                                                                        <i class="mdi mdi-eye"></i>
                                                                    </a>
                                                                    @if(Auth::check() && Auth::user()->isAdmin())
                                                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary waves-effect waves-light">
                                                                        <i class="mdi mdi-pencil"></i>
                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Users Section (Admin Only) -->
                                    @if(Auth::check() && Auth::user()->isAdmin() && count($results['users']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <i class="mdi mdi-account mr-2 text-warning"></i>Users
                                            </h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Role</th>
                                                            <th>Joined</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($results['users'] as $user)
                                                            <tr>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>
                                                                    @if($user->isAdmin())
                                                                        <span class="badge badge-primary">Admin</span>
                                                                    @else
                                                                        <span class="badge badge-secondary">User</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                                <td>
                                                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info waves-effect waves-light">
                                                                        <i class="mdi mdi-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary waves-effect waves-light">
                                                                        <i class="mdi mdi-pencil"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('footer-dash')

        <!-- jQuery  -->
        <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/waves.js') }}"></script>
        <script src="{{ asset('admin/assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('admin/assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('admin/assets/js/jquery.scrollTo.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>

        <!-- Required datatable js -->
        <script src="{{ asset('admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Initialize DataTables
                $('.table').DataTable({
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "responsive": true,
                    "language": {
                        "search": "_INPUT_",
                        "searchPlaceholder": "Search..."
                    }
                });

                // Add smooth hover effect to cards
                $('.card').hover(
                    function() {
                        $(this).addClass('shadow-lg').css('transition', 'all 0.3s ease');
                    },
                    function() {
                        $(this).removeClass('shadow-lg').css('transition', 'all 0.3s ease');
                    }
                );
            });
        </script>
    </body>
</html>