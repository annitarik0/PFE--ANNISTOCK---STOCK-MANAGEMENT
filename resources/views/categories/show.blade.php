<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Category Details</title>
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
                                    <h4 class="page-title m-0">Category Details</h4>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right d-none d-md-block">
                                        <div class="dropdown">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                                                <li class="breadcrumb-item active">{{ $category->name }}</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category details -->
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="mt-0 header-title">Category Information</h4>
                                        <div class="p-3 bg-primary text-white rounded mb-4">
                                            <h2 class="text-white">{{ $category->name }}</h2>
                                            <div class="d-flex align-items-center mt-3">
                                                <div class="mr-4">
                                                    <span class="badge badge-light text-primary p-2">
                                                        <i class="mdi mdi-package-variant mr-1"></i>
                                                        {{ $category->products->count() }} Products
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="badge badge-light text-primary p-2">
                                                        <i class="mdi mdi-calendar mr-1"></i>
                                                        Created {{ $category->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card border-left-primary shadow mb-4">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Total Products
                                                                </div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $category->products->count() }}</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="mdi mdi-package-variant fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card border-left-success shadow mb-4">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                    Last Updated
                                                                </div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $category->updated_at->format('M d, Y') }}</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="mdi mdi-update fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if(Auth::check() && Auth::user()->isAdmin())
                                        <div class="d-flex justify-content-end mb-4">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary waves-effect waves-light mr-2">
                                                <i class="mdi mdi-pencil mr-1"></i> Edit Category
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                                    <i class="mdi mdi-trash-can mr-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Action Cards -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card mb-4">
                                                    <div class="card-body bg-light">
                                                        <h5 class="card-title">
                                                            <i class="mdi mdi-plus-circle text-success mr-2"></i>
                                                            Add New Product
                                                        </h5>
                                                        <p class="card-text">Add a new product to this category.</p>
                                                        <a href="{{ route('products.create') }}" class="btn btn-success waves-effect waves-light">
                                                            <i class="mdi mdi-plus mr-1"></i> Add Product
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card mb-4">
                                                    <div class="card-body bg-light">
                                                        <h5 class="card-title">
                                                            <i class="mdi mdi-view-list text-info mr-2"></i>
                                                            View All Categories
                                                        </h5>
                                                        <p class="card-text">Return to the categories list.</p>
                                                        <a href="{{ route('categories.index') }}" class="btn btn-info waves-effect waves-light">
                                                            <i class="mdi mdi-arrow-left mr-1"></i> Back to List
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <!-- View-only action for employees -->
                                        <div class="card mb-4">
                                            <div class="card-body bg-light">
                                                <h5 class="card-title">
                                                    <i class="mdi mdi-view-list text-info mr-2"></i>
                                                    View All Categories
                                                </h5>
                                                <p class="card-text">Return to the categories list.</p>
                                                <a href="{{ route('categories.index') }}" class="btn btn-info waves-effect waves-light">
                                                    <i class="mdi mdi-arrow-left mr-1"></i> Back to List
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products in this category -->
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h4 class="mt-0 header-title">Products in this Category</h4>
                                        <p class="text-muted m-b-30">Below are all products that belong to the {{ $category->name }} category.</p>
                                    </div>
                                    @if(Auth::check() && Auth::user()->isAdmin())
                                    <div>
                                        <a href="{{ route('products.create') }}" class="btn btn-success waves-effect waves-light">
                                            <i class="mdi mdi-plus-circle mr-1"></i> Add New Product
                                        </a>
                                    </div>
                                    @endif
                                </div>

                                <div class="table-responsive">
                                    <table id="products-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->products as $product)
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-3">
                                                                @if($product->image)
                                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded-circle" width="40" height="40">
                                                                @else
                                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                        <i class="mdi mdi-package-variant text-primary"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                                                <small class="text-muted">ID: #{{ $product->id }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold">{{ $product->price }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 6px;">
                                                            @if($product->quantity > 10)
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                                            @elseif($product->quantity > 0)
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%"></div>
                                                            @else
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 10%"></div>
                                                            @endif
                                                        </div>
                                                        <small class="mt-1 d-block">{{ $product->quantity }} units</small>
                                                    </td>
                                                    <td>
                                                        @if($product->quantity > 10)
                                                            <span class="badge badge-success">In Stock</span>
                                                        @elseif($product->quantity > 0)
                                                            <span class="badge badge-warning">Low Stock</span>
                                                        @else
                                                            <span class="badge badge-danger">Out of Stock</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info waves-effect waves-light">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                        @if(Auth::check() && Auth::user()->isAdmin())
                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary waves-effect waves-light">
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

        <!-- Required datatable js -->
        <script src="{{ asset('admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#products-datatable').DataTable({
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "responsive": true,
                    "language": {
                        "search": "_INPUT_",
                        "searchPlaceholder": "Search Products..."
                    }
                });
            });
        </script>
    </body>
</html>
