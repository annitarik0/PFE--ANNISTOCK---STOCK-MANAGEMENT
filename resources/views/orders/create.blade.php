<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>AnniStock - Create Order</title>
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
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .product-price {
            font-weight: bold;
            color: #28a745;
        }

        .product-quantity {
            color: #6c757d;
        }

        .selected-product {
            background-color: #f8f9fa;
            border: 2px solid #007bff;
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

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="page-title m-0">Create New Order</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="float-right d-none d-md-block">
                                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                        <i class="dripicons-arrow-thin-left"></i> Back to Orders
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <h5>Select Products</h5>
                                        <div class="row" id="productContainer">
                                            @forelse($products as $product)
                                                <div class="col-md-3">
                                                    <div class="product-card" data-product-id="{{ $product->id }}" data-product-price="{{ $product->price }}" data-product-max="{{ $product->quantity }}">
                                                        @if($product->image)
                                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                                        @else
                                                            <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                                                <i class="dripicons-store text-muted" style="font-size: 3rem;"></i>
                                                            </div>
                                                        @endif
                                                        <h6>{{ $product->name }}</h6>
                                                        <p class="product-price">${{ number_format($product->price, 2) }}</p>
                                                        <p class="product-quantity">Available: {{ $product->quantity }}</p>
                                                        <div class="form-group d-none quantity-input">
                                                            <label>Quantity:</label>
                                                            <input type="number" class="form-control" min="1" max="{{ $product->quantity }}" value="1">
                                                        </div>
                                                        <button type="button" class="btn btn-outline-primary btn-sm btn-block select-product">Select</button>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="alert alert-info">
                                                        No products available. Please add products first.
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <h5>Selected Products</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="selectedProductsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Subtotal</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="noProductsRow">
                                                        <td colspan="5" class="text-center">No products selected</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3" class="text-right">Total:</th>
                                                        <th id="totalAmount">$0.00</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Order Name (Optional)</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Enter a custom name for this order">
                                            <small class="form-text text-muted">If left blank, the order will be named "Order #ID"</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="notes">Notes</label>
                                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="submitOrder" disabled>
                                            Create Order
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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

    <script>
        $(document).ready(function() {
            // Handle product selection
            $('.select-product').on('click', function() {
                const card = $(this).closest('.product-card');
                const productId = card.data('product-id');
                const productName = card.find('h6').text();
                const productPrice = card.data('product-price');
                const maxQuantity = card.data('product-max');

                if (card.hasClass('selected-product')) {
                    // Deselect product
                    card.removeClass('selected-product');
                    card.find('.quantity-input').addClass('d-none');
                    $(this).text('Select');

                    // Remove from selected products table
                    $(`#selectedProductsTable tr[data-product-id="${productId}"]`).remove();

                    // Show "No products selected" row if needed
                    if ($('#selectedProductsTable tbody tr').length === 0) {
                        $('#noProductsRow').show();
                        $('#submitOrder').prop('disabled', true);
                    }
                } else {
                    // Select product
                    card.addClass('selected-product');
                    card.find('.quantity-input').removeClass('d-none');
                    $(this).text('Deselect');

                    // Hide "No products selected" row
                    $('#noProductsRow').hide();

                    // Add to selected products table
                    const newRow = `
                        <tr data-product-id="${productId}">
                            <td>${productName}</td>
                            <td>$${productPrice.toFixed(2)}</td>
                            <td>
                                <input type="hidden" name="product_ids[]" value="${productId}">
                                <input type="number" name="quantities[]" class="form-control quantity" min="1" max="${maxQuantity}" value="1" required>
                            </td>
                            <td class="subtotal">$${productPrice.toFixed(2)}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                    <i class="dripicons-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    $('#selectedProductsTable tbody').append(newRow);
                    $('#submitOrder').prop('disabled', false);
                }

                updateTotal();
            });

            // Handle quantity change
            $(document).on('change', '.quantity', function() {
                const row = $(this).closest('tr');
                const price = parseFloat(row.find('td:nth-child(2)').text().replace('$', ''));
                const quantity = parseInt($(this).val());
                const subtotal = price * quantity;

                row.find('.subtotal').text('$' + subtotal.toFixed(2));

                updateTotal();
            });

            // Handle remove product
            $(document).on('click', '.remove-product', function() {
                const row = $(this).closest('tr');
                const productId = row.data('product-id');

                // Deselect the product card
                const card = $(`.product-card[data-product-id="${productId}"]`);
                card.removeClass('selected-product');
                card.find('.quantity-input').addClass('d-none');
                card.find('.select-product').text('Select');

                // Remove the row
                row.remove();

                // Show "No products selected" row if needed
                if ($('#selectedProductsTable tbody tr').length === 0) {
                    $('#noProductsRow').show();
                    $('#submitOrder').prop('disabled', true);
                }

                updateTotal();
            });

            // Update total amount
            function updateTotal() {
                let total = 0;
                $('.subtotal').each(function() {
                    total += parseFloat($(this).text().replace('$', ''));
                });

                $('#totalAmount').text('$' + total.toFixed(2));
            }
        });
    </script>
</body>
</html>
