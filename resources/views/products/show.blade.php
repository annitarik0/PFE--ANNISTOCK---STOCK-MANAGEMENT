<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Product Details</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />

        <style>
            .product-detail-container {
                padding: 40px 0;
            }

            .breadcrumb-container {
                margin-bottom: 30px;
            }

            .breadcrumb {
                background-color: transparent;
                padding: 0;
                margin: 0;
            }

            .breadcrumb-item a {
                color: #6c757d;
                font-size: 14px;
            }

            .breadcrumb-item.active {
                color: #4b6cb7;
                font-weight: 500;
            }

            .product-detail-card {
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 5px 30px rgba(0,0,0,0.08);
                margin-bottom: 30px;
                background-color: white;
            }

            .product-image-container {
                height: 400px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f8f9fa;
                overflow: hidden;
                position: relative;
            }

            .product-image-container img {
                max-height: 90%;
                max-width: 90%;
                object-fit: contain;
                transition: transform 0.5s ease;
            }

            .product-image-container:hover img {
                transform: scale(1.05);
            }

            .product-info {
                padding: 35px;
            }

            .product-category {
                display: inline-block;
                background-color: rgba(75, 108, 183, 0.1);
                color: #4b6cb7;
                padding: 6px 15px;
                border-radius: 20px;
                font-size: 14px;
                margin-bottom: 15px;
                font-weight: 500;
                letter-spacing: 0.5px;
            }

            .product-title {
                font-size: 28px;
                font-weight: 700;
                margin-bottom: 20px;
                color: #333;
                line-height: 1.3;
            }

            .product-price {
                font-size: 26px;
                font-weight: 700;
                color: #4b6cb7;
                margin-bottom: 25px;
                display: flex;
                align-items: center;
            }

            .product-price-label {
                font-size: 16px;
                color: #6c757d;
                margin-right: 10px;
                font-weight: 500;
            }

            .product-stock {
                margin-bottom: 30px;
                display: flex;
                align-items: center;
            }

            .stock-label {
                font-size: 16px;
                color: #6c757d;
                margin-right: 10px;
                font-weight: 500;
            }

            .stock-badge {
                padding: 6px 15px;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
            }

            .stock-badge i {
                margin-right: 5px;
            }

            .in-stock {
                background-color: rgba(2, 197, 141, 0.15);
                color: #02c58d;
            }

            .low-stock {
                background-color: rgba(255, 190, 11, 0.15);
                color: #ffbe0b;
            }

            .out-of-stock {
                background-color: rgba(241, 85, 108, 0.15);
                color: #f1556c;
            }

            .product-description {
                margin-top: 30px;
                padding-top: 25px;
                border-top: 1px solid #eee;
            }

            .product-description h5 {
                font-size: 20px;
                margin-bottom: 15px;
                color: #333;
                font-weight: 600;
            }

            .product-description p {
                color: #6c757d;
                line-height: 1.8;
                font-size: 15px;
            }

            .action-buttons {
                margin-top: 30px;
                display: flex;
                flex-wrap: wrap;
            }

            .action-buttons .btn {
                padding: 12px 25px;
                font-weight: 600;
                border-radius: 8px;
                margin-right: 15px;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
                transition: all 0.3s ease;
            }

            .action-buttons .btn i {
                margin-right: 8px;
                font-size: 18px;
            }

            .btn-primary {
                background-color: #4b6cb7;
                border-color: #4b6cb7;
            }

            .btn-primary:hover {
                background-color: #3a5aa0;
                border-color: #3a5aa0;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(75, 108, 183, 0.2);
            }

            .btn-secondary {
                background-color: #f8f9fa;
                border-color: #e9ecef;
                color: #495057;
            }

            .btn-secondary:hover {
                background-color: #e9ecef;
                color: #212529;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            }

            .related-products {
                margin-top: 50px;
                margin-bottom: 50px;
            }

            .section-header {
                margin-bottom: 30px;
                border-bottom: 1px solid #eee;
                padding-bottom: 15px;
            }

            .section-header h3 {
                font-size: 22px;
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
                display: flex;
                align-items: center;
            }

            .section-header h3 i {
                color: #4b6cb7;
                margin-right: 10px;
                font-size: 24px;
            }

            .section-subtitle {
                color: #6c757d;
                font-size: 14px;
                margin-bottom: 0;
            }

            /* Product Card Styles for Related Products */
            .product-card {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 15px rgba(0,0,0,0.08);
                margin-bottom: 30px;
                transition: all 0.3s ease;
                background-color: white;
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            }

            .product-image {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                transition: all 0.5s ease;
            }

            .product-card:hover .product-image {
                transform: scale(1.05);
            }

            .product-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.03);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: all 0.3s ease;
            }

            .product-card:hover .product-overlay {
                opacity: 1;
            }

            .product-overlay-btn {
                background-color: white;
                color: #4b6cb7;
                border-radius: 50%;
                width: 45px;
                height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 5px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                transform: translateY(20px);
                opacity: 0;
                transition: all 0.3s ease;
            }

            .product-card:hover .product-overlay-btn {
                transform: translateY(0);
                opacity: 1;
            }

            .product-overlay-btn:hover {
                background-color: #4b6cb7;
                color: white;
            }

            .product-name {
                font-size: 18px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
                line-height: 1.4;
            }

            .no-image-placeholder {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #adb5bd;
                font-size: 40px;
            }

            .empty-related-products {
                text-align: center;
                padding: 30px;
                background-color: #f8f9fa;
                border-radius: 10px;
                margin: 20px 0;
            }

            .empty-related-products i {
                font-size: 48px;
                color: #adb5bd;
                margin-bottom: 15px;
            }

            .empty-related-products h4 {
                font-size: 18px;
                color: #495057;
                margin-bottom: 10px;
            }

            .empty-related-products p {
                color: #6c757d;
                margin-bottom: 0;
            }

            .product-stock-info {
                margin-top: 10px;
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
                    <div class="rect5"></div>
                </div>
            </div>
        </div>

        @include('header-dash')

        <!-- Include notification component -->
        @include('components.notification')

        <div class="product-detail-container">
            <div class="container">
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="product-detail-card">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="product-image-container">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100">
                                        <i class="mdi mdi-image-outline" style="font-size: 64px; color: #aaa;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="product-info">
                                <div class="product-category">
                                    <i class="mdi mdi-tag-outline mr-1"></i>
                                    @if(is_object($product->category))
                                        {{ $product->category->name }}
                                    @else
                                        Uncategorized
                                    @endif
                                </div>
                                <h1 class="product-title">{{ $product->name }}</h1>
                                <div class="product-price">
                                    <span class="product-price-label">Price:</span>
                                    {{ $product->formatted_price }}
                                </div>
                                <div class="product-stock">
                                    <span class="stock-label">Availability:</span>
                                    @if($product->quantity > 10)
                                        <span class="stock-badge in-stock">
                                            <i class="mdi mdi-check-circle"></i> In Stock ({{ $product->quantity }} available)
                                        </span>
                                    @elseif($product->quantity > 0)
                                        <span class="stock-badge low-stock">
                                            <i class="mdi mdi-alert-circle"></i> Low Stock ({{ $product->quantity }} left)
                                        </span>
                                    @else
                                        <span class="stock-badge out-of-stock">
                                            <i class="mdi mdi-close-circle"></i> Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <div class="product-description">
                                    <h5>Product Description</h5>
                                    <p>
                                        @if($product->description)
                                            {{ $product->description }}
                                        @else
                                            No description available for this product.
                                        @endif
                                    </p>
                                </div>

                                <div class="action-buttons">
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                        <i class="mdi mdi-arrow-left"></i> Back to Products
                                    </a>

                                    @if($product->quantity > 0)
                                        <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                            <i class="mdi mdi-cart-plus"></i> Add to Order
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products Section -->
                <div class="related-products">
                    <div class="section-header">
                        <h3><i class="mdi mdi-tag-multiple"></i> Related Products</h3>
                        <p class="section-subtitle">Other products in the same category</p>
                    </div>
                    <div class="row">
                        @php
                            // Get related products from the same category, prioritizing those with stock
                            $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->orderBy('quantity', 'desc') // Prioritize products with stock
                                ->take(4)
                                ->get();

                            // If we don't have enough related products, get some from other categories
                            if ($relatedProducts->count() < 4) {
                                $additionalProducts = \App\Models\Product::where('id', '!=', $product->id)
                                    ->where('category_id', '!=', $product->category_id)
                                    ->orderBy('quantity', 'desc')
                                    ->take(4 - $relatedProducts->count())
                                    ->get();

                                $relatedProducts = $relatedProducts->concat($additionalProducts);
                            }
                        @endphp

                        @if($relatedProducts->count() > 0)
                            @foreach($relatedProducts as $relatedProduct)
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="product-card">
                                    <div class="product-image-container" style="height: 180px;">
                                        @if($relatedProduct->image)
                                            <img src="{{ asset($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="product-image">
                                        @else
                                            <div class="no-image-placeholder">
                                                <i class="mdi mdi-image-outline"></i>
                                            </div>
                                        @endif
                                        <div class="product-overlay">
                                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="product-overlay-btn view" title="View Details">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            @if($relatedProduct->quantity > 0)
                                            <a href="{{ route('orders.create') }}" class="product-overlay-btn order" title="Add to Order">
                                                <i class="mdi mdi-cart-plus"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-info" style="padding: 15px;">
                                        <div class="product-category">
                                            @if(is_object($relatedProduct->category))
                                                {{ $relatedProduct->category->name }}
                                            @else
                                                Uncategorized
                                            @endif
                                        </div>
                                        <h3 class="product-name" style="font-size: 16px;">{{ $relatedProduct->name }}</h3>
                                        <div class="product-price" style="font-size: 18px; margin-bottom: 10px;">{{ $relatedProduct->formatted_price }}</div>
                                        <div class="product-stock-info">
                                            @if($relatedProduct->quantity > 10)
                                                <span class="stock-badge in-stock" style="font-size: 12px; padding: 3px 8px;">
                                                    <i class="mdi mdi-check-circle"></i> In Stock
                                                </span>
                                            @elseif($relatedProduct->quantity > 0)
                                                <span class="stock-badge low-stock" style="font-size: 12px; padding: 3px 8px;">
                                                    <i class="mdi mdi-alert-circle"></i> Low Stock
                                                </span>
                                            @else
                                                <span class="stock-badge out-of-stock" style="font-size: 12px; padding: 3px 8px;">
                                                    <i class="mdi mdi-close-circle"></i> Out of Stock
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="empty-related-products">
                                    <i class="mdi mdi-tag-off-outline"></i>
                                    <h4>No related products available</h4>
                                    <p>There are currently no other products in this category.</p>
                                </div>
                            </div>
                        @endif
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
        <script src="{{asset('admin/assets/js/app.js')}}"></script>
    </body>
</html>
