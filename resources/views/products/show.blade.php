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
        <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

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
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                overflow: hidden;
                position: relative;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.08);
                margin: 20px;
            }

            .product-image-container img {
                max-height: 85%;
                max-width: 85%;
                object-fit: contain;
                transition: all 0.5s ease;
                filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
            }

            .product-image-container:hover img {
                transform: scale(1.05);
            }

            /* Image zoom effect */
            .product-image-zoom {
                position: absolute;
                top: 15px;
                right: 15px;
                background-color: rgba(255, 255, 255, 0.9);
                color: #4b6cb7;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                opacity: 0;
                transform: translateY(-10px);
                transition: all 0.3s ease;
                z-index: 10;
            }

            .product-image-container:hover .product-image-zoom {
                opacity: 1;
                transform: translateY(0);
            }

            .product-image-zoom:hover {
                background-color: #4b6cb7;
                color: white;
            }

            /* Modal for zoomed image */
            .image-zoom-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.85);
                z-index: 9999; /* Increased z-index to ensure it's above header */
                overflow: hidden;
                opacity: 0;
                transition: opacity 0.3s ease;
                padding-top: 70px; /* Add padding to account for the header */
            }

            .image-zoom-modal.active {
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 1;
            }

            .zoomed-image-container {
                position: relative;
                width: 90%;
                height: 85%; /* Reduced height to account for header */
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .zoomed-image {
                max-width: 90%;
                max-height: 85%;
                object-fit: contain;
                box-shadow: 0 5px 30px rgba(0,0,0,0.3);
                transform: scale(0.9);
                opacity: 0;
                transition: all 0.4s ease;
            }

            .image-zoom-modal.active .zoomed-image {
                transform: scale(1);
                opacity: 1;
            }

            .zoom-close {
                position: fixed; /* Changed to fixed positioning */
                top: 100px; /* Positioned below the header */
                right: 30px;
                color: white;
                background-color: rgba(255,0,0,0.7); /* More visible red background */
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                font-size: 24px;
                transition: all 0.3s ease;
                z-index: 10000; /* Ensure it's above everything */
                box-shadow: 0 0 15px rgba(0,0,0,0.5);
            }

            .zoom-close:hover {
                background-color: rgba(255,0,0,0.9);
                transform: rotate(90deg) scale(1.1);
            }

            /* Instructions for zoom modal */
            .zoom-instructions {
                position: absolute;
                bottom: 20px;
                left: 0;
                right: 0;
                display: flex;
                justify-content: center;
                gap: 20px;
                color: rgba(255,255,255,0.7);
                font-size: 14px;
                background-color: rgba(0,0,0,0.5);
                padding: 10px;
                border-radius: 30px;
                width: fit-content;
                margin: 0 auto;
                opacity: 0.7;
                transition: opacity 0.3s ease;
            }

            .zoom-instructions:hover {
                opacity: 1;
            }

            .zoom-instructions span {
                display: flex;
                align-items: center;
                white-space: nowrap;
            }

            .zoom-instructions i {
                margin-right: 5px;
                font-size: 16px;
            }

            @media (max-width: 768px) {
                .zoom-instructions {
                    flex-direction: column;
                    gap: 5px;
                    padding: 10px 15px;
                    bottom: 10px;
                }

                .zoom-close {
                    top: 80px;
                    right: 20px;
                    width: 40px;
                    height: 40px;
                }
            }

            /* No image placeholder enhancement */
            .no-image-placeholder {
                width: 80%;
                height: 80%;
                background: linear-gradient(135deg, #f1f3f5 0%, #e9ecef 100%);
                border-radius: 10px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: #adb5bd;
                box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
            }

            .no-image-placeholder i {
                font-size: 80px;
                margin-bottom: 20px;
            }

            .no-image-placeholder span {
                font-size: 16px;
                color: #6c757d;
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
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" id="productImage">
                                    <div class="product-image-zoom" id="zoomButton">
                                        <i class="mdi mdi-magnify-plus"></i>
                                    </div>
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="mdi mdi-image-outline"></i>
                                        <span>No image available</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Image Zoom Modal -->
                            @if($product->image)
                            <div class="image-zoom-modal" id="imageZoomModal">
                                <div class="zoomed-image-container">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="zoomed-image">
                                    <div class="zoom-instructions">
                                        <span><i class="mdi mdi-gesture-swipe"></i> Drag to move</span>
                                        <span><i class="mdi mdi-gesture-tap-hold"></i> Double-click to reset</span>
                                        <span><i class="mdi mdi-keyboard"></i> ESC to close</span>
                                    </div>
                                </div>
                                <div class="zoom-close" id="zoomClose" title="Close (ESC)">
                                    <i class="mdi mdi-close"></i>
                                </div>
                            </div>
                            @endif
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
                                            <div class="no-image-placeholder" style="width: 100%; height: 100%; font-size: 40px;">
                                                <i class="mdi mdi-image-outline"></i>
                                            </div>
                                        @endif
                                        <div class="product-overlay">
                                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="product-overlay-btn view" title="View Details">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
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

        <!-- Product Image Zoom Functionality -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get elements
                const zoomButton = document.getElementById('zoomButton');
                const zoomModal = document.getElementById('imageZoomModal');
                const zoomClose = document.getElementById('zoomClose');
                const productImage = document.getElementById('productImage');
                const zoomedImage = document.querySelector('.zoomed-image');

                // Get instructions element
                const zoomInstructions = document.querySelector('.zoom-instructions');

                // Only initialize if we have a product image
                if (zoomButton && zoomModal && zoomClose) {
                    // Open modal on zoom button click
                    zoomButton.addEventListener('click', function() {
                        zoomModal.classList.add('active');
                        document.body.style.overflow = 'hidden'; // Prevent scrolling

                        // Add animation class to zoomed image
                        setTimeout(() => {
                            zoomedImage.style.opacity = '1';
                            zoomedImage.style.transform = 'scale(1)';

                            // Show instructions briefly, then fade them
                            if (zoomInstructions) {
                                zoomInstructions.style.opacity = '1';
                                setTimeout(() => {
                                    zoomInstructions.style.opacity = '0.7';
                                }, 3000);
                            }
                        }, 100);
                    });

                    // Close modal on close button click
                    zoomClose.addEventListener('click', function() {
                        closeZoomModal();
                    });

                    // Close modal on background click
                    zoomModal.addEventListener('click', function(e) {
                        if (e.target === zoomModal) {
                            closeZoomModal();
                        }
                    });

                    // Close modal on ESC key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && zoomModal.classList.contains('active')) {
                            closeZoomModal();
                        }
                    });

                    // Function to close modal
                    function closeZoomModal() {
                        zoomedImage.style.opacity = '0';
                        zoomedImage.style.transform = 'scale(0.9)';

                        // Add a visual feedback when closing
                        zoomClose.style.transform = 'rotate(90deg) scale(0.8)';

                        setTimeout(() => {
                            zoomModal.classList.remove('active');
                            document.body.style.overflow = ''; // Restore scrolling
                            // Reset the transform for next time
                            zoomClose.style.transform = '';
                        }, 300);
                    }

                    // Allow image dragging in zoom mode
                    let isDragging = false;
                    let startX, startY, translateX = 0, translateY = 0;

                    zoomedImage.addEventListener('mousedown', function(e) {
                        isDragging = true;
                        startX = e.clientX - translateX;
                        startY = e.clientY - translateY;
                        zoomedImage.style.cursor = 'grabbing';
                    });

                    document.addEventListener('mousemove', function(e) {
                        if (!isDragging) return;

                        translateX = e.clientX - startX;
                        translateY = e.clientY - startY;

                        zoomedImage.style.transform = `translate(${translateX}px, ${translateY}px)`;
                    });

                    document.addEventListener('mouseup', function() {
                        isDragging = false;
                        zoomedImage.style.cursor = 'grab';
                    });

                    // Double click to reset position
                    zoomedImage.addEventListener('dblclick', function() {
                        translateX = 0;
                        translateY = 0;
                        zoomedImage.style.transform = 'translate(0, 0)';
                    });
                }
            });
        </script>
    </body>
</html>
