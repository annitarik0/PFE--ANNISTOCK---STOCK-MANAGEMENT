<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>AnniStock - Order Details</title>
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
        .page-title-box {
            padding: 30px 0 20px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }

        .page-title i {
            color: #4b6cb7;
            margin-right: 10px;
            font-size: 28px;
        }

        .back-btn {
            background-color: #4b6cb7;
            color: white;
            border-radius: 6px;
            padding: 8px 15px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .back-btn i {
            margin-right: 5px;
        }

        .back-btn:hover {
            background-color: #3a5aa0;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .order-info-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
            margin-bottom: 25px;
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .order-info-card:hover {
            box-shadow: 0 6px 22px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .order-info-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #5d7dcb 100%);
            padding: 16px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .order-info-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-info-header h5 i {
            margin-right: 10px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 20px;
        }

        .order-info-body {
            padding: 22px;
            background-color: #fcfcfc;
        }

        .info-row {
            display: flex;
            margin-bottom: 16px;
            align-items: center;
            border-bottom: 1px dashed rgba(0,0,0,0.07);
            padding-bottom: 16px;
        }

        .info-row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            width: 140px;
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .info-label i {
            margin-right: 8px;
            color: #4b6cb7;
            font-size: 16px;
        }

        .info-value {
            flex: 1;
            color: #333;
            font-size: 15px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            min-width: 120px;
            justify-content: center;
        }

        .status-pending {
            background: linear-gradient(135deg, #ffbe0b 0%, #ffce3a 100%);
            color: #fff;
        }

        .status-processing {
            background: linear-gradient(135deg, #38a4f8 0%, #5ab5fa 100%);
            color: #fff;
        }

        .status-completed {
            background: linear-gradient(135deg, #02c58d 0%, #0fd99a 100%);
            color: #fff;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #f1556c 0%, #f47a8c 100%);
            color: #fff;
        }

        .status-badge i {
            margin-right: 6px;
            font-size: 15px;
        }

        .update-status-form {
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        .update-status-form label {
            margin-right: 15px;
            margin-bottom: 0;
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .update-status-form label i {
            margin-right: 8px;
            color: #4b6cb7;
            font-size: 18px;
        }

        .update-status-form select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            background-color: white;
            font-size: 14px;
            color: #495057;
            margin-right: 15px;
            min-width: 180px;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234b6cb7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }

        .update-status-form select:focus {
            outline: none;
            border-color: #4b6cb7;
            box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
        }

        .update-btn {
            background: linear-gradient(135deg, #4b6cb7 0%, #5d7dcb 100%);
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(75, 108, 183, 0.2);
            min-width: 120px;
        }

        .update-btn i {
            margin-right: 8px;
            font-size: 16px;
        }

        .update-btn:hover {
            background: linear-gradient(135deg, #3a5aa0 0%, #4b6cb7 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(75, 108, 183, 0.25);
        }

        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .items-table th {
            background: linear-gradient(135deg, #4b6cb7 0%, #5d7dcb 100%);
            color: white;
            font-weight: 600;
            padding: 16px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.7px;
            text-align: center;
        }

        .items-table td {
            padding: 16px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
            color: #495057;
        }

        .items-table tbody tr {
            transition: all 0.2s ease;
            background-color: white;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .items-table tbody tr:hover {
            background-color: #f0f4ff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .items-table tfoot th {
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
            border-top: 2px solid #e9ecef;
            font-weight: 700;
            color: #333;
            font-size: 14px;
            padding: 16px;
        }

        .items-table tfoot th:last-child {
            color: #4b6cb7;
            font-size: 16px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border: 3px solid white;
            transition: all 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        .product-info {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-left: 20px;
        }

        .product-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            text-align: left;
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

    <div class="container">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title">
                        <i class="mdi mdi-clipboard-text-outline"></i> Order #{{ $order->id }} Details
                    </h4>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('orders.index') }}" class="back-btn">
                        <i class="mdi mdi-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="order-info-card">
                    <div class="order-info-header">
                        <h5><i class="mdi mdi-clipboard-text"></i> Order Information</h5>
                    </div>
                    <div class="order-info-body">
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-pound"></i> Order ID:
                            </div>
                            <div class="info-value">#{{ $order->id }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-calendar"></i> Date:
                            </div>
                            <div class="info-value">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-cash-multiple"></i> Total Amount:
                            </div>
                            <div class="info-value">${{ number_format($order->total_amount, 2) }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-tag-outline"></i> Status:
                            </div>
                            <div class="info-value">
                                @if($order->status === 'pending')
                                    <span class="status-badge status-pending">
                                        <i class="mdi mdi-clock-outline"></i> Pending
                                    </span>
                                @elseif($order->status === 'processing')
                                    <span class="status-badge status-processing">
                                        <i class="mdi mdi-progress-clock"></i> Processing
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="status-badge status-completed">
                                        <i class="mdi mdi-check-circle"></i> Completed
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="status-badge status-cancelled">
                                        <i class="mdi mdi-close-circle"></i> Cancelled
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- Removed order notes to prevent potential problems -->
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="order-info-card">
                    <div class="order-info-header">
                        <h5><i class="mdi mdi-account"></i> Customer Information</h5>
                    </div>
                    <div class="order-info-body">
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-account"></i> Name:
                            </div>
                            <div class="info-value">{{ $order->user->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-email-outline"></i> Email:
                            </div>
                            <div class="info-value">{{ $order->user->email }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-shield-account"></i> Role:
                            </div>
                            <div class="info-value">{{ ucfirst($order->user->role) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::user()->isAdmin())
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('orders.update', $order) }}" method="POST" class="update-status-form">
                        @csrf
                        @method('PUT')
                        <label for="status">
                            <i class="mdi mdi-tag-outline"></i> Update Status:
                        </label>
                        <select name="status" id="status">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="update-btn">
                            <i class="mdi mdi-content-save"></i> Update
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="order-info-card">
                    <div class="order-info-header">
                        <h5><i class="mdi mdi-cart"></i> Order Items</h5>
                    </div>
                    <div class="order-info-body">
                        <div class="table-responsive">
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th width="40%">Product</th>
                                        <th width="20%">Price</th>
                                        <th width="20%">Quantity</th>
                                        <th width="20%">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    @if($item->product->image)
                                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="product-image">
                                                    @else
                                                        <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                                            <i class="mdi mdi-package-variant text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <span class="product-name">{{ $item->product->name }}</span>
                                                </div>
                                            </td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total:</th>
                                        <th>${{ number_format($order->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
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
</body>
</html>
