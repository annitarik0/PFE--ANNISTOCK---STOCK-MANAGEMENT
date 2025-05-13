<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>AnniStock - Create New Order</title>
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
        .create-order-container {
            padding: 30px 0;
        }

        .create-order-header {
            margin-bottom: 30px;
        }

        .create-order-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .create-order-title i {
            color: #4b6cb7;
            margin-right: 10px;
            font-size: 28px;
        }

        .create-order-subtitle {
            color: #6c757d;
            margin-bottom: 0;
        }

        .btn-back {
            background-color: #4b6cb7;
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-back i {
            margin-right: 8px;
            font-size: 18px;
        }

        .btn-back:hover {
            background-color: #3a5aa0;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .order-form-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .order-form-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
        }

        .order-form-card .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }

        .order-form-card .card-header h5 i {
            margin-right: 8px;
            color: #4b6cb7;
        }

        .order-form-card .card-body {
            padding: 20px;
            background-color: white;
        }

        /* Enhanced Order Summary Card */
        .order-summary-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(75, 108, 183, 0.15);
            border: 1px solid rgba(75, 108, 183, 0.1);
            transition: all 0.3s ease;
        }

        .order-summary-card .card-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            padding: 18px 20px;
            border-bottom: none;
            text-align: center;
        }

        .order-summary-card .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .order-summary-card .card-header h5 i {
            margin-right: 10px;
            font-size: 22px;
        }

        .order-summary-card .card-body {
            padding: 25px 10px;
            background-color: white;
        }

        /* Add more space to the order summary container */
        .selected-products {
            padding: 0;
            width: 100%;
            overflow-x: auto; /* Add horizontal scrolling if needed */
        }

        /* Make the table take full width */
        .selected-products-table {
            width: 100%;
            table-layout: fixed; /* Fixed table layout for better control */
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .product-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
            cursor: pointer;
            position: relative;
        }

        .product-card::before {
            content: 'Click to select/unselect';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0,0,0,0.6);
            color: white;
            text-align: center;
            padding: 5px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2;
        }

        .product-card:hover::before {
            opacity: 1;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .product-card.selected {
            border: 2px solid #4b6cb7;
            box-shadow: 0 5px 15px rgba(75, 108, 183, 0.2);
            transform: translateY(-5px);
        }

        .product-card.selected::after {
            content: '\F12C';
            font-family: 'Material Design Icons';
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #4b6cb7;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            z-index: 3;
        }

        .product-card.selected::before {
            content: 'Click to unselect';
            background-color: rgba(75, 108, 183, 0.7);
        }

        .product-image-container {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            overflow: hidden;
        }

        .product-image {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            transition: all 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .product-price {
            font-size: 18px;
            font-weight: 700;
            color: #4b6cb7;
            margin-bottom: 5px;
        }

        .product-stock {
            font-size: 14px;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .product-stock i {
            margin-right: 5px;
            font-size: 16px;
            color: #02c58d;
        }

        .search-bar {
            margin-bottom: 20px;
            position: relative;
        }

        .search-bar input {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px 10px 40px;
            width: 100%;
            font-size: 14px;
            color: #495057;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #4b6cb7;
            box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 18px;
        }

        .selected-products-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 25px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .selected-products-table th {
            background-color: #eef2ff;
            padding: 15px 8px;
            text-align: center;
            font-weight: 600;
            color: #4b6cb7;
            border-bottom: 1px solid #d1deff;
        }

        .selected-products-table td {
            padding: 15px 8px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
            text-align: center;
        }

        /* Set specific widths for table columns */
        .selected-products-table th:nth-child(1),
        .selected-products-table td:nth-child(1) {
            width: 35%;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            padding-left: 10px;
        }

        .selected-products-table th:nth-child(2),
        .selected-products-table td:nth-child(2) {
            width: 30%;
            padding: 15px 5px;
        }

        .selected-products-table th:nth-child(3),
        .selected-products-table td:nth-child(3) {
            width: 20%;
            padding-right: 5px;
        }

        .selected-products-table th:nth-child(4),
        .selected-products-table td:nth-child(4) {
            width: 15%;
            min-width: 45px;
            padding: 15px 10px 15px 0;
        }

        .selected-products-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .selected-products-table tbody tr:last-child td {
            border-bottom: 2px solid #d1deff;
        }

        .selected-products-table tfoot th {
            background-color: #eef2ff;
            padding: 18px 15px;
            text-align: center;
            font-weight: 600;
            color: #4b6cb7;
        }

        .selected-products-table tfoot tr {
            background-color: #eef2ff;
        }

        .total-row {
            background-color: #e0e9ff !important;
        }

        .empty-selection {
            text-align: center;
            padding: 30px 20px;
            color: #6c757d;
            font-style: italic;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        /* Quantity control wrapper */
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            width: 100%;
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e9ff 100%);
            border-radius: 20px;
            padding: 2px;
            border: 1px solid #d1deff;
            box-shadow: 0 2px 5px rgba(75, 108, 183, 0.1);
            max-width: 95px;
        }

        /* Quantity buttons */
        .qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 1px solid #d1deff;
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e9ff 100%);
            color: #4b6cb7;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(75, 108, 183, 0.1);
            flex-shrink: 0;
            padding: 0;
            line-height: 1;
        }

        .qty-btn:hover {
            background: linear-gradient(135deg, #e0e9ff 0%, #d1deff 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(75, 108, 183, 0.2);
        }

        .qty-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(75, 108, 183, 0.1);
        }

        /* Quantity input */
        .quantity-input {
            width: 40px;
            border: none;
            border-radius: 0;
            padding: 0;
            margin: 0 5px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: #4b6cb7;
            background-color: transparent;
            transition: all 0.3s ease;
            display: block;
        }

        .quantity-input:focus {
            outline: none;
            background-color: transparent;
        }

        /* Hide number input arrows */
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .quantity-input[type=number] {
            -moz-appearance: textfield;
        }

        @keyframes new-row {
            0% { background-color: #e0e9ff; transform: translateY(-10px); opacity: 0; }
            100% { background-color: transparent; transform: translateY(0); opacity: 1; }
        }

        .new-row-animation {
            animation: new-row 0.5s ease-out;
        }

        .btn-remove {
            background-color: #f1556c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(241, 85, 108, 0.3);
            margin: 0 auto;
            position: relative;
            z-index: 10; /* Higher z-index to ensure visibility */
            min-width: 30px; /* Ensure minimum width */
            right: 0; /* Align to the right */
            float: right; /* Float to the right */
        }

        .btn-remove:hover {
            background-color: #e63e57;
            transform: scale(1.15) rotate(90deg);
            box-shadow: 0 4px 8px rgba(241, 85, 108, 0.4);
        }

        .btn-remove i {
            font-size: 14px;
            line-height: 1;
        }

        /* Ensure the button column doesn't collapse */
        .selected-products-table td:last-child {
            min-width: 40px;
            padding-right: 10px;
        }

        /* Product name cell styling */
        .product-name-cell {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 500;
            cursor: default;
            padding-right: 5px;
            font-size: 14px;
            display: block;
        }

        .total-amount {
            font-size: 28px;
            font-weight: 700;
            color: #4b6cb7;
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e9ff 100%);
            padding: 12px 20px;
            border-radius: 50px;
            display: inline-block;
            box-shadow: 0 3px 10px rgba(75, 108, 183, 0.15);
            border: 1px solid rgba(75, 108, 183, 0.2);
            transition: all 0.3s ease;
            text-align: center;
            min-width: 180px;
            margin: 0 auto;
        }

        @keyframes highlight-pulse {
            0% { transform: scale(1); box-shadow: 0 3px 10px rgba(75, 108, 183, 0.15); }
            50% { transform: scale(1.05); background: linear-gradient(135deg, #e0e9ff 0%, #d1deff 100%); box-shadow: 0 5px 15px rgba(75, 108, 183, 0.3); }
            100% { transform: scale(1); box-shadow: 0 3px 10px rgba(75, 108, 183, 0.15); }
        }

        .highlight-total {
            animation: highlight-pulse 0.5s ease;
        }

        .notes-textarea {
            border-radius: 12px;
            border: 1px solid #d1deff;
            padding: 15px;
            width: 100%;
            font-size: 14px;
            color: #495057;
            resize: vertical;
            min-height: 120px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            margin-bottom: 25px;
        }

        .notes-textarea:focus {
            outline: none;
            border-color: #4b6cb7;
            box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
            background-color: white;
        }

        .form-group label {
            font-weight: 600;
            color: #4b6cb7;
            margin-bottom: 10px;
            display: block;
            text-align: center;
            font-size: 16px;
        }

        .btn-create-order {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            border-radius: 50px;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 4px 15px rgba(75, 108, 183, 0.3);
            margin-top: 10px;
        }

        .btn-create-order i {
            margin-right: 10px;
            font-size: 22px;
        }

        .btn-create-order:hover {
            background: linear-gradient(135deg, #3a5aa0 0%, #0f1c36 100%);
            color: white;
            text-decoration: none;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(75, 108, 183, 0.4);
        }

        .btn-create-order:disabled {
            background: linear-gradient(135deg, #adb5bd 0%, #6c757d 100%);
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
        }

        .empty-selection {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
        }

        .category-filter {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .category-btn {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #e9ecef;
            border-radius: 20px;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .category-btn:hover {
            background-color: #e9ecef;
        }

        .category-btn.active {
            background-color: #4b6cb7;
            color: white;
            border-color: #4b6cb7;
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

    <div class="create-order-container">
        <div class="container">
            <div class="create-order-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="create-order-title">
                            <i class="mdi mdi-cart-plus"></i> Create New Order
                        </h1>
                        <p class="create-order-subtitle">Select products and specify quantities to create an order</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('orders.index') }}" class="btn-back">
                            <i class="mdi mdi-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>

            <form action="{{ route('orders.store') }}" method="POST" id="order-create-form">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="order-form-card">
                            <div class="card-header">
                                <h5><i class="mdi mdi-package-variant"></i> Select Products</h5>
                            </div>
                            <div class="card-body">
                                <div class="search-bar">
                                    <i class="mdi mdi-magnify"></i>
                                    <input type="text" id="productSearch" placeholder="Search products by name...">
                                </div>

                                <div class="category-filter">
                                    <button type="button" class="category-btn active" data-category="all">All Categories</button>
                                    @php
                                        $categories = \App\Models\Category::all();
                                    @endphp
                                    @foreach($categories as $category)
                                        <button type="button" class="category-btn" data-category="{{ $category->id }}">{{ $category->name }}</button>
                                    @endforeach
                                </div>

                                <div class="product-grid">
                                    @forelse($products as $product)
                                        <div class="product-card"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->price }}"
                                            data-product-max="{{ $product->quantity }}"
                                            data-category="{{ $product->category_id }}"
                                            title="Click to select/unselect this product">
                                            <div class="product-image-container">
                                                @if($product->image)
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center h-100 w-100">
                                                        <i class="mdi mdi-package-variant" style="font-size: 48px; color: #adb5bd;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-info">
                                                <h3 class="product-name">{{ $product->name }}</h3>
                                                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                                                <div class="product-stock">
                                                    <i class="mdi mdi-check-circle"></i> {{ $product->quantity }} in stock
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p>No products available.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="order-form-card order-summary-card">
                            <div class="card-header">
                                <h5><i class="mdi mdi-clipboard-text-outline"></i> Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="selected-products">
                                    <table class="selected-products-table" id="selectedProductsTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 35%;">Product</th>
                                                <th style="width: 30%;">Qty</th>
                                                <th style="width: 20%;">Price</th>
                                                <th style="width: 15%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="selectedProductsList">
                                            <tr id="emptySelectionRow">
                                                <td colspan="4" class="empty-selection">No products selected</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="total-row">
                                                <th colspan="4" class="text-center">
                                                    <div style="margin-bottom: 10px; font-size: 16px;">Total Amount</div>
                                                    <div class="total-amount" id="totalAmount">$0.00</div>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!-- Removed notes field as it doesn't exist in the database -->

                                    <button type="submit" class="btn-create-order" id="submitOrder" disabled>
                                        <i class="mdi mdi-check-circle"></i> Create Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            // Let's try a simpler approach - direct form submission without AJAX
            $('#order-create-form').on('submit', function(e) {
                // Don't prevent default form submission

                // Check if any products are selected
                if ($('#selectedProductsList tr').length === 0 || $('#emptySelectionRow').length > 0) {
                    alert('Please select at least one product before creating an order.');
                    return false;
                }

                // Show loading indicator
                $('#submitOrder').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');

                // Let the form submit normally
                return true;
            });
            // Product selection
            $('.product-card').on('click', function() {
                const productId = $(this).data('product-id');
                const productName = $(this).data('product-name');
                const productPrice = parseFloat($(this).data('product-price'));
                const maxQuantity = parseInt($(this).data('product-max'));

                // Check if product is already selected
                if ($(`#selectedProductsList tr[data-product-id="${productId}"]`).length > 0) {
                    // Product already selected, remove it (toggle selection)
                    $(`#selectedProductsList tr[data-product-id="${productId}"]`).remove();
                    $(this).removeClass('selected');

                    // If no products selected, show empty selection row
                    if ($('#selectedProductsList tr').length === 0) {
                        $('#selectedProductsList').append('<tr id="emptySelectionRow"><td colspan="4" class="empty-selection">No products selected</td></tr>');
                        $('#submitOrder').prop('disabled', true);
                    }

                    // Update total
                    updateTotal();
                    return;
                }

                // Add visual selection indicator
                $(this).addClass('selected');

                // Remove empty selection row if it exists
                $('#emptySelectionRow').remove();

                // Add to selected products table
                const newRow = `
                    <tr data-product-id="${productId}" class="new-row-animation">
                        <td>
                            <span title="${productName}" class="product-name-cell">
                                ${productName.length > 12 ? productName.substring(0, 12) + '...' : productName}
                            </span>
                        </td>
                        <td>
                            <input type="hidden" name="product_ids[]" value="${productId}">
                            <div class="quantity-control">
                                <div class="qty-btn qty-decrease"><i class="mdi mdi-minus"></i></div>
                                <input type="number" name="quantities[]" class="quantity-input" min="1" max="${maxQuantity}" value="1" required>
                                <div class="qty-btn qty-increase"><i class="mdi mdi-plus"></i></div>
                            </div>
                        </td>
                        <td class="product-price">$${productPrice.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn-remove">
                                <i class="mdi mdi-close"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#selectedProductsList').append(newRow);

                // Add animation class and then remove it after animation completes
                setTimeout(function() {
                    $(`#selectedProductsList tr[data-product-id="${productId}"]`).removeClass('new-row-animation');
                }, 500);

                // Enable submit button
                $('#submitOrder').prop('disabled', false);

                // Update total
                updateTotal();
            });

            // Remove product from selection
            $(document).on('click', '.btn-remove', function(e) {
                // Stop event propagation to prevent other click handlers
                e.stopPropagation();

                const row = $(this).closest('tr');
                const productId = row.data('product-id');

                // Remove selection indicator from product card
                $(`.product-card[data-product-id="${productId}"]`).removeClass('selected');

                // Remove row
                row.remove();

                // If no products selected, show empty selection row
                if ($('#selectedProductsList tr').length === 0) {
                    $('#selectedProductsList').append('<tr id="emptySelectionRow"><td colspan="4" class="empty-selection">No products selected</td></tr>');
                    $('#submitOrder').prop('disabled', true);
                }

                // Update total
                updateTotal();
            });

            // Update quantity when input changes
            $(document).on('change', '.quantity-input', function() {
                // Ensure value is within min/max range
                const min = parseInt($(this).attr('min'));
                const max = parseInt($(this).attr('max'));
                let val = parseInt($(this).val());

                if (isNaN(val) || val < min) {
                    $(this).val(min);
                } else if (val > max) {
                    $(this).val(max);
                }

                updateTotal();
            });

            // Handle quantity decrease button
            $(document).on('click', '.qty-decrease', function() {
                const input = $(this).siblings('.quantity-input');
                const min = parseInt(input.attr('min'));
                let val = parseInt(input.val());

                if (val > min) {
                    input.val(val - 1).trigger('change');
                }
            });

            // Handle quantity increase button
            $(document).on('click', '.qty-increase', function() {
                const input = $(this).siblings('.quantity-input');
                const max = parseInt(input.attr('max'));
                let val = parseInt(input.val());

                if (val < max) {
                    input.val(val + 1).trigger('change');
                }
            });

            // Search products
            $('#productSearch').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();

                $('.product-card').each(function() {
                    const productName = $(this).data('product-name').toLowerCase();

                    if (productName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Category filter
            $('.category-btn').on('click', function() {
                const category = $(this).data('category');

                // Update active button
                $('.category-btn').removeClass('active');
                $(this).addClass('active');

                if (category === 'all') {
                    $('.product-card').show();
                } else {
                    $('.product-card').each(function() {
                        if ($(this).data('category') == category) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });

            // Calculate total
            function updateTotal() {
                let total = 0;

                $('#selectedProductsList tr').each(function() {
                    if (!$(this).attr('id') || $(this).attr('id') !== 'emptySelectionRow') {
                        const price = parseFloat($(this).find('.product-price').text().replace('$', ''));
                        const quantity = parseInt($(this).find('.quantity-input').val());

                        total += price * quantity;
                    }
                });

                // Update total with animation effect
                const totalElement = $('#totalAmount');
                totalElement.text('$' + total.toFixed(2));

                // Add highlight animation
                totalElement.addClass('highlight-total');
                setTimeout(function() {
                    totalElement.removeClass('highlight-total');
                }, 500);
            }
        });
    </script>
</body>
</html>
