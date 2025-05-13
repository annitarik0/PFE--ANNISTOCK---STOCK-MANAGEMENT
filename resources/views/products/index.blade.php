<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Products Management</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />

        <style>
            .products-container {
                padding: 30px 0;
            }

            .products-header {
                margin-bottom: 30px;
            }

            .products-title {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }

            .products-title i {
                color: #4b6cb7;
                margin-right: 10px;
                font-size: 28px;
            }

            .products-subtitle {
                color: #6c757d;
                margin-bottom: 0;
            }

            .product-card {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 15px rgba(0,0,0,0.05);
                margin-bottom: 30px;
                background-color: white;
                border: 1px solid rgba(0,0,0,0.03);
            }

            .btn-create-product {
                background-color: #4b6cb7;
                color: white;
                border-radius: 8px;
                padding: 10px 20px;
                font-size: 14px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                transition: all 0.2s ease;
            }

            .btn-create-product i {
                margin-right: 8px;
                font-size: 18px;
            }

            .btn-create-product:hover {
                background-color: #3a5aa0;
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
            }

            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 10px; /* Consistent spacing between buttons */
            }

            .btn-view, .btn-edit, .btn-delete {
                background-color: #4b6cb7;
                color: white;
                border-radius: 6px;
                padding: 7px 12px;
                font-size: 13px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                min-width: 80px;
                border: none;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                height: 34px; /* Fixed height for consistency */
            }

            .btn-view i, .btn-edit i, .btn-delete i {
                margin-right: 5px;
                font-size: 15px;
            }

            .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
                color: white;
                text-decoration: none;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }

            .btn-view:hover, .btn-edit:hover {
                background-color: #3a5aa0;
            }

            .btn-delete {
                background-color: #f1556c;
            }

            .btn-delete:hover {
                background-color: #e63e57;
            }

            .products-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }

            .products-table th {
                background: linear-gradient(to bottom, #f8f9fa, #f1f3f5);
                color: #495057;
                font-weight: 600;
                padding: 15px;
                border-bottom: 2px solid #e9ecef;
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 0.5px;
                text-align: center;
            }

            .products-table td {
                padding: 15px;
                border-bottom: 1px solid #e9ecef;
                vertical-align: middle;
                transition: all 0.2s ease;
                text-align: center;
            }

            .products-table tbody tr {
                transition: all 0.2s ease;
            }

            .products-table tbody tr:hover {
                background-color: #f8f9fa;
                transform: translateY(-1px);
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .products-table tbody tr:last-child td {
                border-bottom: none;
            }

            .product-image-container {
                width: 80px;
                height: 80px;
                margin: 0 auto;
                position: relative;
                border-radius: 10px;
                overflow: hidden;
                background-color: #f8f9fa;
                box-shadow: 0 3px 10px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .product-image-container:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.12);
            }

            .product-image {
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                transition: all 0.3s ease;
            }

            .product-image-container:hover .product-image {
                transform: scale(1.08);
            }

            .product-image-placeholder {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #adb5bd;
                font-size: 28px;
                margin: 0 auto;
                transition: all 0.3s ease;
                box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
            }

            .product-image-placeholder:hover {
                color: #6c757d;
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            }

            .empty-products {
                text-align: center;
                padding: 50px 20px;
                background-color: #f8f9fa;
                border-radius: 10px;
                margin: 30px 0;
            }

            .empty-products i {
                font-size: 48px;
                color: #adb5bd;
                margin-bottom: 20px;
                display: block;
            }

            .empty-products h3 {
                font-size: 20px;
                color: #495057;
                margin-bottom: 10px;
            }

            .empty-products p {
                color: #6c757d;
                margin-bottom: 20px;
            }
        </style>
    </head>

    <body>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>

        @include('header-dash')

        <!-- Include notification component -->
        @include('components.notification')
        <div class="products-container">
            <div class="container">
                <div class="products-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="products-title">
                                <i class="mdi mdi-package-variant-closed"></i>
                                @if(isset($filterType) && isset($title))
                                    {{ $title }}
                                    @if($filterType == 'low-stock')
                                        <span class="badge badge-warning ml-2" style="font-size: 12px; vertical-align: middle;">Low Stock</span>
                                    @elseif($filterType == 'out-of-stock')
                                        <span class="badge badge-danger ml-2" style="font-size: 12px; vertical-align: middle;">Out of Stock</span>
                                    @endif
                                @else
                                    Products Management
                                @endif
                            </h1>
                            <p class="products-subtitle">
                                @if(isset($filterType))
                                    Showing filtered products - <a href="{{ route('products.index') }}" class="text-primary">View all products</a>
                                @else
                                    View and manage your products
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                            <a href="{{ route('products.create') }}" class="btn-create-product">
                                <i class="mdi mdi-plus-circle"></i> Create New Product
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="table-responsive">
                        <table class="products-table">
                            <thead>
                                <tr>
                                    <th width="10%">Image</th>
                                    <th width="20%">Name</th>
                                    <th width="15%">Price</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Category</th>
                                    <th width="25%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image)
                                            <div class="product-image-container">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                            </div>
                                        @else
                                            <div class="product-image-placeholder">
                                                <i class="mdi mdi-package-variant"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->formatted_price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @if(is_object($product->category))
                                            {{ $product->category->name }}
                                        @else
                                            Uncategorized
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn-view">
                                                <i class="mdi mdi-eye"></i> View
                                            </a>

                                            @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn-edit">
                                                <i class="mdi mdi-pencil"></i> Edit
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin: 0; padding: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <i class="mdi mdi-delete"></i> Delete
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-products">
                                            <i class="mdi mdi-package-variant-closed-remove"></i>
                                            <h3>No Products Found</h3>
                                            <p>You haven't created any products yet.</p>
                                            @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                            <a href="{{ route('products.create') }}" class="btn-create-product">
                                                <i class="mdi mdi-plus-circle"></i> Create Your First Product
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@include('footer-dash')

        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.slimscroll.js')}}"></script>

        <!--Morris Chart-->
        <script src="../plugins/morris/morris.min.js')}}"></script>
        <script src="../plugins/raphael/raphael.min.js')}}"></script>

        <!-- dashboard js -->
        <script src="{{asset('admin/assets/pages/dashboard.int.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>

    </body>
</html>
