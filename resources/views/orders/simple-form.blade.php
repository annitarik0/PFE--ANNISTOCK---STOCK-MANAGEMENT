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
    <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

    <!-- App css -->
    <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
    @include('header-dash')
    @include('components.notification')

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create New Order (Simple Form)</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/store-order') }}" method="POST">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Removed notes field as it doesn't exist in the database -->

                            <h5 class="mt-4 mb-3">Select Products</h5>

                            <div class="row">
                                @foreach($products as $product)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">Price: ${{ number_format($product->price, 2) }}</p>
                                            <p class="card-text">In Stock: {{ $product->quantity }}</p>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="product-{{ $product->id }}" name="product_select[]" value="{{ $product->id }}">
                                                <label class="form-check-label" for="product-{{ $product->id }}">
                                                    Select
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label for="quantity-{{ $product->id }}">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity-{{ $product->id }}"
                                                    name="quantity[{{ $product->id }}]" min="1" max="{{ $product->quantity }}" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Create Order</button>
                                <a href="{{ url('/orders') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer-dash')

    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/app.js')}}"></script>
</body>
</html>
