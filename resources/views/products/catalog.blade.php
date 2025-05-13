<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Product Catalog</title>
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
            .catalog-container {
                padding: 30px 0;
            }

            .catalog-header {
                margin-bottom: 30px;
                text-align: center;
            }

            .catalog-title {
                font-size: 28px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
            }

            .catalog-subtitle {
                font-size: 16px;
                color: #6c757d;
                max-width: 600px;
                margin: 0 auto;
            }

            .filter-bar {
                background-color: #f8f9fa;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 30px;
                box-shadow: 0 3px 15px rgba(0,0,0,0.08);
                border: 1px solid rgba(0,0,0,0.03);
            }

            .filter-bar .form-group {
                margin-bottom: 0;
                position: relative;
            }

            .filter-bar label {
                font-weight: 600;
                color: #4b6cb7;
                margin-bottom: 8px;
                display: block;
                font-size: 14px;
                letter-spacing: 0.5px;
            }

            .filter-bar select {
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                padding: 10px 15px;
                background-color: white;
                width: 100%;
                font-size: 14px;
                color: #495057;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234b6cb7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 10px center;
                background-size: 16px;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .filter-bar select:focus {
                outline: none;
                border-color: #4b6cb7;
                box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
            }

            .filter-bar .filter-icon {
                position: absolute;
                top: 38px;
                left: 12px;
                color: #4b6cb7;
                font-size: 16px;
            }

            .filter-bar .filter-title {
                font-size: 18px;
                font-weight: 600;
                color: #333;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
            }

            .filter-bar .filter-title i {
                margin-right: 8px;
                color: #4b6cb7;
            }

            .filter-bar .filter-reset {
                color: #4b6cb7;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                margin-left: auto;
            }

            .filter-bar .filter-reset i {
                margin-right: 5px;
                font-size: 16px;
            }

            .filter-bar .filter-reset:hover {
                color: #3a5aa0;
                text-decoration: none;
            }

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

            .product-image-container {
                height: 200px;
                overflow: hidden;
                position: relative;
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
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

            .product-overlay-btn.view {
                transition-delay: 0.05s;
            }

            .product-overlay-btn.order {
                transition-delay: 0.1s;
            }

            .product-info {
                padding: 20px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .product-category {
                font-size: 12px;
                color: #6c757d;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 8px;
            }

            .product-name {
                font-size: 18px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
                line-height: 1.4;
            }

            .product-price {
                font-size: 20px;
                font-weight: 700;
                color: #4b6cb7;
                margin-bottom: 15px;
            }

            .product-stock {
                margin-top: auto;
                padding-top: 15px;
                border-top: 1px solid #f1f1f1;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .stock-badge {
                padding: 5px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
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

            .view-btn {
                color: #4b6cb7;
                font-size: 14px;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
            }

            .view-btn i {
                margin-left: 5px;
                transition: transform 0.2s ease;
            }

            .view-btn:hover i {
                transform: translateX(3px);
            }

            .pagination-container {
                margin-top: 20px;
                display: flex;
                justify-content: center;
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

            /* Fade transition for filtering */
            .fade-transition {
                opacity: 0.5;
                transition: opacity 0.3s ease;
            }

            /* Pagination styling */
            .pagination {
                display: flex;
                padding-left: 0;
                list-style: none;
                border-radius: 0.25rem;
            }

            .pagination .page-item .page-link {
                position: relative;
                display: block;
                padding: 0.5rem 0.75rem;
                margin-left: -1px;
                line-height: 1.25;
                color: #4b6cb7;
                background-color: #fff;
                border: 1px solid #dee2e6;
                transition: all 0.2s ease;
            }

            .pagination .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #4b6cb7;
                border-color: #4b6cb7;
            }

            .pagination .page-item .page-link:hover {
                z-index: 2;
                color: #3a5aa0;
                text-decoration: none;
                background-color: #e9ecef;
                border-color: #dee2e6;
            }

            /* Empty state styling */
            .empty-state {
                text-align: center;
                padding: 40px 20px;
                background-color: #f8f9fa;
                border-radius: 10px;
                margin: 30px 0;
            }

            .empty-state i {
                font-size: 48px;
                color: #adb5bd;
                margin-bottom: 20px;
                display: block;
            }

            .empty-state h3 {
                font-size: 20px;
                color: #495057;
                margin-bottom: 10px;
            }

            .empty-state p {
                color: #6c757d;
                margin-bottom: 20px;
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

        <div class="catalog-container">
            <div class="container">
                <div class="catalog-header">
                    <h1 class="catalog-title">Product Catalog</h1>
                    <p class="catalog-subtitle">Browse our inventory and find the products you need</p>
                </div>

                <div class="filter-bar">
                    <div class="filter-title">
                        <i class="mdi mdi-filter-variant"></i> Filter Products
                        <a href="javascript:void(0)" id="reset-filters" class="filter-reset">
                            <i class="mdi mdi-refresh"></i> Reset Filters
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category-filter">
                                    <i class="mdi mdi-tag-outline mr-1"></i> Category
                                </label>
                                <select id="category-filter">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sort-by">
                                    <i class="mdi mdi-sort mr-1"></i> Sort By
                                </label>
                                <select id="sort-by">
                                    <option value="name">Name (A-Z)</option>
                                    <option value="name-desc">Name (Z-A)</option>
                                    <option value="price-low">Price: Low to High</option>
                                    <option value="price-high">Price: High to Low</option>
                                    <option value="newest">Newest First</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock-filter">
                                    <i class="mdi mdi-package-variant mr-1"></i> Availability
                                </label>
                                <select id="stock-filter">
                                    <option value="">All Products</option>
                                    <option value="in-stock">In Stock</option>
                                    <option value="low-stock">Low Stock</option>
                                    <option value="out-of-stock">Out of Stock</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="product-grid">
                    @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 product-item" data-id="{{ $product->id }}">
                        <input type="hidden" class="category-id" value="{{ $product->category_id }}">
                        <div class="product-card">
                            <div class="product-image-container">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="mdi mdi-image-outline"></i>
                                    </div>
                                @endif
                                <div class="product-overlay">
                                    <a href="{{ route('products.show', $product->id) }}" class="product-overlay-btn view" title="View Details">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @if($product->quantity > 0)
                                    <a href="{{ route('orders.create') }}" class="product-overlay-btn order" title="Add to Order">
                                        <i class="mdi mdi-cart-plus"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">
                                    @if(is_object($product->category))
                                        {{ $product->category->name }}
                                    @else
                                        Uncategorized
                                    @endif
                                </div>
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <div class="product-price">{{ $product->formatted_price }}</div>
                                <div class="product-stock">
                                    @if($product->quantity > 10)
                                        <span class="stock-badge in-stock">
                                            <i class="mdi mdi-check-circle mr-1"></i> In Stock
                                        </span>
                                    @elseif($product->quantity > 0)
                                        <span class="stock-badge low-stock">
                                            <i class="mdi mdi-alert-circle mr-1"></i> Low Stock
                                        </span>
                                    @else
                                        <span class="stock-badge out-of-stock">
                                            <i class="mdi mdi-close-circle mr-1"></i> Out of Stock
                                        </span>
                                    @endif
                                    <a href="{{ route('products.show', $product->id) }}" class="view-btn">
                                        Details <i class="mdi mdi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="pagination-container">
                    {{ $products->links() }}
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

        <script>
            $(document).ready(function() {
                // Add data attributes to product items for easier filtering
                $('.product-item').each(function() {
                    const $item = $(this);
                    const $card = $item.find('.product-card');

                    // Extract category ID from the hidden input
                    const categoryId = $item.find('.category-id').val();
                    $item.attr('data-category', categoryId);

                    // Extract price for sorting
                    const priceText = $item.find('.product-price').text().replace('$', '').trim();
                    const price = parseFloat(priceText);
                    $item.attr('data-price', price);

                    // Extract stock status
                    if ($item.find('.stock-badge.in-stock').length) {
                        $item.attr('data-stock', 'in-stock');
                    } else if ($item.find('.stock-badge.low-stock').length) {
                        $item.attr('data-stock', 'low-stock');
                    } else {
                        $item.attr('data-stock', 'out-of-stock');
                    }
                });

                // Category filter
                $('#category-filter').on('change', function() {
                    applyFilters();
                });

                // Sort by filter
                $('#sort-by').on('change', function() {
                    applyFilters();
                });

                // Stock filter
                $('#stock-filter').on('change', function() {
                    applyFilters();
                });

                // Reset filters
                $('#reset-filters').on('click', function() {
                    $('#category-filter').val('');
                    $('#sort-by').val('name');
                    $('#stock-filter').val('');
                    applyFilters();
                });

                function applyFilters() {
                    const categoryId = $('#category-filter').val();
                    const sortBy = $('#sort-by').val();
                    const stockStatus = $('#stock-filter').val();

                    // First, filter the items
                    $('.product-item').each(function() {
                        const $item = $(this);
                        let visible = true;

                        // Category filter
                        if (categoryId && $item.attr('data-category') !== categoryId) {
                            visible = false;
                        }

                        // Stock filter
                        if (stockStatus && $item.attr('data-stock') !== stockStatus) {
                            visible = false;
                        }

                        $item.toggle(visible);
                    });

                    // Then, sort the visible items
                    const $productGrid = $('#product-grid');
                    const $items = $('.product-item:visible').detach();

                    // Sort items based on selected option
                    $items.sort(function(a, b) {
                        const $a = $(a);
                        const $b = $(b);

                        if (sortBy === 'name') {
                            const nameA = $a.find('.product-name').text().toUpperCase();
                            const nameB = $b.find('.product-name').text().toUpperCase();
                            return nameA.localeCompare(nameB);
                        }
                        else if (sortBy === 'name-desc') {
                            const nameA = $a.find('.product-name').text().toUpperCase();
                            const nameB = $b.find('.product-name').text().toUpperCase();
                            return nameB.localeCompare(nameA);
                        }
                        else if (sortBy === 'price-low') {
                            return parseFloat($a.attr('data-price')) - parseFloat($b.attr('data-price'));
                        }
                        else if (sortBy === 'price-high') {
                            return parseFloat($b.attr('data-price')) - parseFloat($a.attr('data-price'));
                        }
                        else if (sortBy === 'newest') {
                            // For simplicity, we'll use the product ID as a proxy for "newest"
                            // In a real app, you'd use a timestamp or ID if they're sequential
                            const idA = parseInt($a.attr('data-id'));
                            const idB = parseInt($b.attr('data-id'));
                            return idB - idA;
                        }

                        return 0;
                    });

                    // Reattach the sorted items
                    $productGrid.append($items);

                    // Show a message if no products match the filters
                    if ($('.product-item:visible').length === 0) {
                        if (!$('#no-products-message').length) {
                            $productGrid.append('<div id="no-products-message" class="col-12 text-center py-5"><div class="alert alert-info"><i class="mdi mdi-information-outline mr-2"></i>No products match your selected filters. <a href="javascript:void(0)" id="clear-filters">Clear filters</a> to see all products.</div></div>');

                            $('#clear-filters').on('click', function() {
                                $('#reset-filters').click();
                            });
                        }
                    } else {
                        $('#no-products-message').remove();
                    }

                    // Update the filter counts
                    updateFilterCounts();
                }

                function updateFilterCounts() {
                    // Update category counts
                    const categoryId = $('#category-filter').val();
                    const stockStatus = $('#stock-filter').val();

                    // Count visible products
                    const visibleCount = $('.product-item:visible').length;
                    const totalCount = $('.product-item').length;

                    // Update the subtitle with count information
                    $('.catalog-subtitle').html(`Showing <strong>${visibleCount}</strong> of <strong>${totalCount}</strong> products`);
                }

                // Initialize filters on page load
                updateFilterCounts();

                // Add animation to filter changes
                $('.filter-bar select').on('change', function() {
                    $('#product-grid').addClass('fade-transition');
                    setTimeout(function() {
                        $('#product-grid').removeClass('fade-transition');
                    }, 500);
                });
            });
        </script>
    </body>
</html>
