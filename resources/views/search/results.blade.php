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
        <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

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
            /* Search section styling */
            .search-section-title {
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
                margin-bottom: 15px;
                font-weight: 600;
                color: #333;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .search-section-title .section-actions {
                display: flex;
                align-items: center;
            }

            .search-section-title .section-actions .btn {
                margin-left: 8px;
                padding: 4px 10px;
                font-size: 12px;
            }

            /* Card styling */
            .card {
                border-radius: 4px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                margin-bottom: 20px;
                transition: all 0.3s ease;
                border: none;
                overflow: hidden;
            }

            .card:hover {
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                transform: translateY(-3px);
            }

            .card .card-img-top {
                height: 160px;
                object-fit: cover;
                background-color: #f8f9fa;
            }

            .card .stock-badge {
                position: absolute;
                top: 10px;
                right: 10px;
                z-index: 10;
            }

            /* Search form styling */
            .search-again {
                background-color: #f8f9fa;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .search-options {
                padding-top: 15px;
                border-top: 1px solid #eee;
                margin-top: 15px;
            }

            /* Badge styling */
            .badge {
                padding: 5px 10px;
                font-weight: 500;
                border-radius: 4px;
            }

            .suggestion-badge {
                margin-right: 8px;
                margin-bottom: 8px;
                padding: 8px 12px;
                background-color: #f1f3f9;
                color: #4e73df;
                border: 1px solid #e1e5f1;
                font-weight: 400;
                transition: all 0.2s ease;
                display: inline-block;
            }

            .suggestion-badge:hover {
                background-color: #4e73df;
                color: #fff;
                text-decoration: none;
            }

            /* Table styling */
            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
                border-top: none;
            }

            .table-bordered {
                border: 1px solid #e9ecef;
            }

            .table-bordered th, .table-bordered td {
                border: 1px solid #e9ecef;
            }

            /* Icon styling */
            .mdi {
                font-size: 18px;
                vertical-align: middle;
                margin-right: 5px;
            }

            /* Search input styling */
            .input-group {
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            }

            .input-group-text {
                border: none;
                background-color: #4e73df;
                color: white;
                padding: 0 15px;
            }

            .form-control-lg {
                border: none;
                box-shadow: none;
                font-size: 16px;
                padding: 12px 20px;
                height: auto;
            }

            .form-control-lg:focus {
                box-shadow: none;
                background-color: #fff;
            }

            .btn-lg {
                padding: 12px 20px;
                font-weight: 500;
            }

            /* Form controls */
            .form-control {
                border: 1px solid #e1e5f1;
                border-radius: 4px;
                padding: 8px 12px;
                transition: all 0.2s ease;
            }

            .form-control:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            }

            /* Animation effects */
            .pulse-animation {
                animation: pulse 0.5s;
            }

            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.4); }
                70% { box-shadow: 0 0 0 10px rgba(78, 115, 223, 0); }
                100% { box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
            }

            /* Search suggestions */
            .search-suggestions {
                background-color: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
            }

            .suggestions-list {
                display: flex;
                flex-wrap: wrap;
            }

            /* Product card enhancements */
            .product-card {
                height: 100%;
            }

            .product-card .card-body {
                display: flex;
                flex-direction: column;
            }

            .product-card .card-text {
                flex-grow: 1;
                margin-bottom: 15px;
            }

            .product-price {
                font-weight: 600;
                font-size: 16px;
                color: #4e73df;
            }

            .product-category {
                font-size: 12px;
                color: #6c757d;
                margin-bottom: 10px;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .search-options .col-md-4 {
                    margin-bottom: 15px;
                }
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
                                    <form action="{{ route('search') }}" method="GET" id="search-form">
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

                                        <!-- Advanced search options -->
                                        <div class="search-options mt-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="filter" class="text-muted">Filter by:</label>
                                                        <select name="filter" id="filter" class="form-control">
                                                            <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Results</option>
                                                            <option value="products" {{ $filter == 'products' ? 'selected' : '' }}>Products Only</option>
                                                            @if(Auth::check() && Auth::user()->isAdmin())
                                                            <option value="categories" {{ $filter == 'categories' ? 'selected' : '' }}>Categories Only</option>
                                                            <option value="users" {{ $filter == 'users' ? 'selected' : '' }}>Users Only</option>
                                                            @endif
                                                            <option value="orders" {{ $filter == 'orders' ? 'selected' : '' }}>Orders Only</option>
                                                            <option value="in-stock" {{ $filter == 'in-stock' ? 'selected' : '' }}>In Stock Products</option>
                                                            <option value="out-of-stock" {{ $filter == 'out-of-stock' ? 'selected' : '' }}>Out of Stock Products</option>
                                                            <option value="completed-orders" {{ $filter == 'completed-orders' ? 'selected' : '' }}>Completed Orders</option>
                                                            <option value="pending-orders" {{ $filter == 'pending-orders' ? 'selected' : '' }}>Pending Orders</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="sort" class="text-muted">Sort by:</label>
                                                        <select name="sort" id="sort" class="form-control">
                                                            <option value="relevance" {{ $sort == 'relevance' ? 'selected' : '' }}>Relevance</option>
                                                            <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                                            <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                                            <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                                                            <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                                                            <option value="date_asc" {{ $sort == 'date_asc' ? 'selected' : '' }}>Date (Oldest First)</option>
                                                            <option value="date_desc" {{ $sort == 'date_desc' ? 'selected' : '' }}>Date (Newest First)</option>
                                                            <option value="quantity_asc" {{ $sort == 'quantity_asc' ? 'selected' : '' }}>Quantity (Low to High)</option>
                                                            <option value="quantity_desc" {{ $sort == 'quantity_desc' ? 'selected' : '' }}>Quantity (High to Low)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="per_page" class="text-muted">Results per page:</label>
                                                        <select name="per_page" id="per_page" class="form-control">
                                                            <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                                                            <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>24</option>
                                                            <option value="48" {{ $perPage == 48 ? 'selected' : '' }}>48</option>
                                                            <option value="96" {{ $perPage == 96 ? 'selected' : '' }}>96</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Search suggestions -->
                                @if(isset($suggestions) && count($suggestions) > 0)
                                <div class="search-suggestions mb-4">
                                    <h6 class="text-muted mb-2">Related searches:</h6>
                                    <div class="suggestions-list">
                                        @foreach($suggestions as $suggestion)
                                            <a href="{{ route('search', ['query' => $suggestion]) }}" class="badge badge-light suggestion-badge">
                                                {{ $suggestion }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <script>
                                    // Add animation to search input when focused
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const searchInput = document.getElementById('dynamic-search');
                                        const filterSelect = document.getElementById('filter');
                                        const sortSelect = document.getElementById('sort');
                                        const perPageSelect = document.getElementById('per_page');

                                        // Auto-submit form when filter, sort, or per_page changes
                                        filterSelect.addEventListener('change', function() {
                                            document.getElementById('search-form').submit();
                                        });

                                        sortSelect.addEventListener('change', function() {
                                            document.getElementById('search-form').submit();
                                        });

                                        perPageSelect.addEventListener('change', function() {
                                            document.getElementById('search-form').submit();
                                        });

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

                                @if($totalResults == 0)
                                    <div class="alert alert-info">
                                        <i class="mdi mdi-information-outline mr-2"></i>
                                        No results found for "<strong>{{ $query }}</strong>". Please try a different search term.
                                    </div>

                                    <div class="search-tips mt-4 mb-4">
                                        <h5 class="mb-3">Search Tips:</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Try using more general terms</li>
                                            <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Check your spelling</li>
                                            <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Try searching for a single word instead of a phrase</li>
                                            <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Make sure you have permission to view the content you're searching for</li>
                                        </ul>
                                    </div>

                                    <div class="text-center mt-4">
                                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                            <i class="mdi mdi-home mr-1"></i> Return to Dashboard
                                        </a>

                                        @if(Auth::check() && Auth::user()->isAdmin())
                                            <a href="{{ route('products.index') }}" class="btn btn-info ml-2">
                                                <i class="mdi mdi-package-variant mr-1"></i> Browse Products
                                            </a>
                                            <a href="{{ route('categories.index') }}" class="btn btn-success ml-2">
                                                <i class="mdi mdi-tag-multiple mr-1"></i> Browse Categories
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <!-- Products Section -->
                                    @if(count($results['products']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <div>
                                                    <i class="mdi mdi-package-variant mr-2 text-primary"></i>Products
                                                    <span class="badge badge-light ml-2">{{ count($results['products']) }}</span>
                                                </div>
                                                <div class="section-actions">
                                                    @if($filter != 'products')
                                                        <a href="{{ route('search', ['query' => $query, 'filter' => 'products', 'sort' => $sort]) }}" class="btn btn-sm btn-outline-primary">
                                                            View All Products
                                                        </a>
                                                    @endif
                                                    @if($filter != 'in-stock')
                                                        <a href="{{ route('search', ['query' => $query, 'filter' => 'in-stock', 'sort' => $sort]) }}" class="btn btn-sm btn-outline-success">
                                                            In Stock Only
                                                        </a>
                                                    @endif
                                                </div>
                                            </h5>
                                            <div class="row">
                                                @foreach($results['products'] as $product)
                                                    <div class="col-md-4 col-lg-3 mb-4">
                                                        <div class="card h-100 product-card">
                                                            <!-- Stock badge -->
                                                            @if($product->quantity <= 0)
                                                                <span class="badge badge-danger stock-badge">Out of Stock</span>
                                                            @elseif($product->quantity <= 5)
                                                                <span class="badge badge-warning stock-badge">Low Stock</span>
                                                            @else
                                                                <span class="badge badge-success stock-badge">In Stock</span>
                                                            @endif

                                                            <!-- Product image -->
                                                            @if($product->image)
                                                                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                                            @else
                                                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light">
                                                                    <i class="mdi mdi-package-variant" style="font-size: 48px; color: #ccc;"></i>
                                                                </div>
                                                            @endif

                                                            <div class="card-body">
                                                                <div class="product-category">
                                                                    {{ $product->category ? $product->category->name : 'No Category' }}
                                                                </div>
                                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                                <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                                                    <div>
                                                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info waves-effect waves-light">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>
                                                                        @if(Auth::check() && Auth::user()->isAdmin())
                                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary waves-effect waves-light">
                                                                            <i class="mdi mdi-pencil"></i>
                                                                        </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                                                <small class="text-muted">Quantity: {{ $product->quantity }}</small>
                                                                <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if(count($results['products']) >= 12 && $filter == 'products')
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('products.index', ['search' => $query]) }}" class="btn btn-outline-primary">
                                                        View All Products <i class="mdi mdi-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Categories Section (Admin Only) -->
                                    @if(Auth::check() && Auth::user()->isAdmin() && count($results['categories']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <div>
                                                    <i class="mdi mdi-tag-multiple mr-2 text-success"></i>Categories
                                                    <span class="badge badge-light ml-2">{{ count($results['categories']) }}</span>
                                                </div>
                                                <div class="section-actions">
                                                    @if($filter != 'categories')
                                                        <a href="{{ route('search', ['query' => $query, 'filter' => 'categories', 'sort' => $sort]) }}" class="btn btn-sm btn-outline-success">
                                                            View All Categories
                                                        </a>
                                                    @endif
                                                </div>
                                            </h5>
                                            <div class="row">
                                                @foreach($results['categories'] as $category)
                                                    <div class="col-md-4 col-lg-3 mb-4">
                                                        <div class="card h-100">
                                                            <!-- Category badge -->
                                                            @php
                                                                $productCount = method_exists($category, 'products') ? $category->products->count() : 0;
                                                            @endphp

                                                            @if($productCount > 0)
                                                                <span class="badge badge-success stock-badge">{{ $productCount }} Products</span>
                                                            @else
                                                                <span class="badge badge-warning stock-badge">Empty</span>
                                                            @endif

                                                            <!-- Category image or icon -->
                                                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light">
                                                                <i class="mdi mdi-tag-multiple" style="font-size: 48px; color: #28a745;"></i>
                                                            </div>

                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $category->name }}</h5>
                                                                <p class="card-text">{{ $category->description ? Str::limit($category->description, 100) : 'No description available' }}</p>
                                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                                    <div>
                                                                        <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="btn btn-sm btn-outline-success waves-effect waves-light">
                                                                            <i class="mdi mdi-view-grid mr-1"></i> Browse
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-info waves-effect waves-light">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary waves-effect waves-light">
                                                                            <i class="mdi mdi-pencil"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if(count($results['categories']) >= 6 && $filter == 'categories')
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-success">
                                                        View All Categories <i class="mdi mdi-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Orders Section -->
                                    @if(count($results['orders']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <div>
                                                    <i class="mdi mdi-clipboard-text mr-2 text-danger"></i>Orders
                                                    <span class="badge badge-light ml-2">{{ count($results['orders']) }}</span>
                                                </div>
                                                <div class="section-actions">
                                                    @if($filter != 'orders')
                                                        <a href="{{ route('search', ['query' => $query, 'filter' => 'orders', 'sort' => $sort]) }}" class="btn btn-sm btn-outline-danger">
                                                            View All Orders
                                                        </a>
                                                    @endif
                                                    @if($filter != 'completed-orders')
                                                        <a href="{{ route('search', ['query' => $query, 'filter' => 'completed-orders', 'sort' => $sort]) }}" class="btn btn-sm btn-outline-success">
                                                            Completed Only
                                                        </a>
                                                    @endif
                                                    @if($filter != 'pending-orders')
                                                        <a href="{{ route('search', ['query' => $query, 'filter' => 'pending-orders', 'sort' => $sort]) }}" class="btn btn-sm btn-outline-warning">
                                                            Pending Only
                                                        </a>
                                                    @endif
                                                </div>
                                            </h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Order #</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Items</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($results['orders'] as $order)
                                                            <tr>
                                                                <td><strong>{{ $order->id }}</strong></td>
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
                                                                <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                                                <td>{{ $order->items ? $order->items->count() : 0 }}</td>
                                                                <td>
                                                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info waves-effect waves-light">
                                                                        <i class="mdi mdi-eye"></i>
                                                                    </a>
                                                                    @if(Auth::check() && Auth::user()->isAdmin())
                                                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-primary waves-effect waves-light">
                                                                        <i class="mdi mdi-pencil"></i>
                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if(count($results['orders']) >= 8 && $filter == 'orders')
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('orders.index', ['search' => $query]) }}" class="btn btn-outline-danger">
                                                        View All Orders <i class="mdi mdi-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Users Section (Admin Only) -->
                                    @if(Auth::check() && Auth::user()->isAdmin() && count($results['users']) > 0)
                                        <div class="search-section mb-4">
                                            <h5 class="search-section-title">
                                                <div>
                                                    <i class="mdi mdi-account mr-2 text-warning"></i>Users
                                                    <span class="badge badge-light ml-2">{{ count($results['users']) }}</span>
                                                </div>
                                                <div class="section-actions">
                                                    @if($filter != 'users')
                                                        <a href="{{ route('search', ['query' => $query, 'filter' => 'users', 'sort' => $sort]) }}" class="btn btn-sm btn-outline-warning">
                                                            View All Users
                                                        </a>
                                                    @endif
                                                </div>
                                            </h5>

                                            <div class="row">
                                                @foreach($results['users'] as $user)
                                                    <div class="col-md-4 col-lg-3 mb-4">
                                                        <div class="card h-100">
                                                            <!-- User role badge -->
                                                            @if($user->isAdmin())
                                                                <span class="badge badge-primary stock-badge">Admin</span>
                                                            @else
                                                                <span class="badge badge-secondary stock-badge">Employee</span>
                                                            @endif

                                                            <!-- User image -->
                                                            @if($user->image)
                                                                <img src="{{ asset($user->image) }}" class="card-img-top" alt="{{ $user->name }}">
                                                            @else
                                                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light">
                                                                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; font-size: 36px; color: #6c757d; font-weight: bold;">
                                                                        {{ substr($user->name, 0, 1) }}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $user->name }}</h5>
                                                                <p class="card-text">{{ $user->email }}</p>
                                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                                    <small class="text-muted">Joined: {{ $user->created_at->format('M d, Y') }}</small>
                                                                    <div>
                                                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info waves-effect waves-light">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary waves-effect waves-light">
                                                                            <i class="mdi mdi-pencil"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-white">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <small class="text-muted">
                                                                        <i class="mdi mdi-clipboard-text mr-1"></i>
                                                                        {{ method_exists($user, 'orders') ? $user->orders->count() : 0 }} Orders
                                                                    </small>
                                                                    <a href="{{ route('orders.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-outline-secondary">
                                                                        View Orders
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if(count($results['users']) >= 6 && $filter == 'users')
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('users.index', ['search' => $query]) }}" class="btn btn-outline-warning">
                                                        View All Users <i class="mdi mdi-arrow-right ml-1"></i>
                                                    </a>
                                                </div>
                                            @endif
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
        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/detect.js')}}"></script>
        <script src="{{asset('admin/assets/js/fastclick.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.scrollTo.min.js')}}"></script>

        <!-- Required datatable js -->
        <script src="{{asset('admin/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>
    </body>
</html>