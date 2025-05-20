<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>AnniStock - {{ $order->getDisplayName() }} Details</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- App Icons -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

    <!-- App css -->
    <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .order-details-container {
            padding: 30px 0;
        }

        .order-details-header {
            margin-bottom: 30px;
        }

        .order-details-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .order-details-title i {
            color: #4b6cb7;
            margin-right: 10px;
            font-size: 28px;
        }

        .order-details-subtitle {
            color: #6c757d;
            margin-bottom: 0;
        }

        .btn-back {
            background-color: #f8f9fa;
            color: #495057;
            border-radius: 8px;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
            border: 1px solid #e9ecef;
        }

        .btn-back i {
            margin-right: 5px;
            font-size: 16px;
        }

        .btn-back:hover {
            background-color: #e9ecef;
            color: #212529;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .order-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .order-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
        }

        .order-card .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        .order-card .card-header h5 i {
            margin-right: 10px;
            color: #4b6cb7;
        }

        .order-card .card-body {
            padding: 25px;
            background-color: white;
        }

        .order-info-grid {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px 20px;
        }

        .order-info-item {
            flex: 1 0 200px;
            margin: 10px;
            padding: 20px;
            background-color: #f8f9fa;
            border-left: 3px solid #4b6cb7;
            transition: all 0.2s ease;
        }

        .order-info-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .order-info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .order-status {
            display: inline-block;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 3px;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-processing {
            background-color: #CCE5FF;
            color: #004085;
        }

        .status-completed {
            background-color: #D4EDDA;
            color: #155724;
        }

        .status-cancelled {
            background-color: #F8D7DA;
            color: #721C24;
        }

        .order-notes {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #6c757d;
        }

        .order-notes-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-notes-value {
            font-size: 14px;
            color: #333;
            white-space: pre-line;
        }

        .user-info {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
            background-color: #4b6cb7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: 600;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .user-email {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .user-role {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            background-color: rgba(75, 108, 183, 0.15);
            color: #4b6cb7;
        }

        .user-role.admin {
            background-color: rgba(241, 85, 108, 0.15);
            color: #f1556c;
        }

        .order-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-items-table th {
            background-color: #4b6cb7;
            padding: 12px 15px;
            text-align: center;
            font-weight: 600;
            color: white;
            font-size: 13px;
        }

        .order-items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
            color: #495057;
        }

        .order-items-table tbody tr {
            background-color: white;
        }

        .order-items-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .order-items-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .order-items-table tfoot th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: right;
            font-weight: 700;
            color: #495057;
            border-top: 2px solid #e9ecef;
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            overflow: hidden;
            margin-right: 12px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image i {
            font-size: 24px;
            color: #adb5bd;
        }

        .product-details {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .product-name {
            font-weight: 600;
            color: #333;
            text-align: left;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 700;
            color: #4b6cb7;
            letter-spacing: 0.5px;
        }

        .status-form {
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
            border-radius: 10px;
            margin-bottom: 25px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .status-form-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .status-form-title i {
            margin-right: 10px;
            color: #4b6cb7;
            font-size: 20px;
        }

        .status-select {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 8px 12px;
            background-color: white;
            width: 100%;
            font-size: 14px;
            color: #495057;
            margin-bottom: 15px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234b6cb7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }

        .status-select:focus {
            outline: none;
            border-color: #4b6cb7;
            box-shadow: 0 0 0 2px rgba(75, 108, 183, 0.15);
        }

        .btn-update-status {
            background-color: #4b6cb7;
            color: white;
            border-radius: 4px;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .btn-update-status i {
            margin-right: 8px;
            font-size: 16px;
        }

        .btn-update-status:hover {
            background-color: #3a5aa0;
            color: white;
        }

        .success-alert {
            background-color: #e6f7f0;
            border: 1px solid #d1f0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #02c58d;
            display: flex;
            align-items: center;
        }

        .success-alert i {
            margin-right: 10px;
            font-size: 20px;
        }

        .error-alert {
            background-color: #feeef0;
            border: 1px solid #fcdde2;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #f1556c;
            display: flex;
            align-items: center;
        }

        .error-alert i {
            margin-right: 10px;
            font-size: 20px;
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

    <div class="order-details-container">
        <div class="container">
            <div class="order-details-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="order-details-title">
                            <i class="mdi mdi-clipboard-text-outline"></i> {{ $order->getDisplayName() }} Details
                        </h1>
                        <p class="order-details-subtitle">View detailed information about this order</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('orders.index') }}" class="btn-back">
                            <i class="mdi mdi-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="success-alert">
                    <i class="mdi mdi-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="error-alert">
                    <i class="mdi mdi-alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="order-card">
                        <div class="card-header">
                            <h5><i class="mdi mdi-clipboard-text"></i> Order Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="order-info-grid">
                                <div class="order-info-item">
                                    <div class="order-info-label">
                                        <i class="mdi mdi-pound"></i> Order ID
                                    </div>
                                    <div class="order-info-value">#{{ $order->id }}</div>
                                </div>

                                <div class="order-info-item">
                                    <div class="order-info-label">
                                        <i class="mdi mdi-calendar"></i> Date
                                    </div>
                                    <div class="order-info-value">{{ $order->created_at->format('M d, Y') }}</div>
                                </div>

                                <div class="order-info-item">
                                    <div class="order-info-label">
                                        <i class="mdi mdi-clock-outline"></i> Time
                                    </div>
                                    <div class="order-info-value">{{ $order->created_at->format('h:i A') }}</div>
                                </div>

                                <div class="order-info-item">
                                    <div class="order-info-label">
                                        <i class="mdi mdi-tag-outline"></i> Status
                                    </div>
                                    <div class="order-info-value">
                                        @if($order->status === 'pending')
                                            <span class="order-status status-pending">
                                                <i class="mdi mdi-clock-outline mr-1"></i> Pending
                                            </span>
                                        @elseif($order->status === 'processing')
                                            <span class="order-status status-processing">
                                                <i class="mdi mdi-progress-clock mr-1"></i> Processing
                                            </span>
                                        @elseif($order->status === 'completed')
                                            <span class="order-status status-completed">
                                                <i class="mdi mdi-check-circle mr-1"></i> Completed
                                            </span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="order-status status-cancelled">
                                                <i class="mdi mdi-close-circle mr-1"></i> Cancelled
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="order-info-item">
                                    <div class="order-info-label">
                                        <i class="mdi mdi-cash-multiple"></i> Total Amount
                                    </div>
                                    <div class="order-info-value">${{ number_format($order->total_amount, 2) }}</div>
                                </div>

                                <div class="order-info-item">
                                    <div class="order-info-label">
                                        <i class="mdi mdi-package-variant-closed"></i> Items
                                    </div>
                                    <div class="order-info-value">{{ $order->items->count() }} items</div>
                                </div>
                            </div>

                            @if($order->notes)
                                <div class="order-notes">
                                    <div class="order-notes-label">Order Notes</div>
                                    <div class="order-notes-value">{{ $order->notes }}</div>
                                </div>
                            @endif

                            <div class="user-info">
                                <div class="user-avatar">
                                    @if($order->user->image)
                                        <img src="{{ asset($order->user->image) }}" alt="{{ $order->user->name }}">
                                    @else
                                        {{ substr($order->user->name, 0, 1) }}
                                    @endif
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $order->user->name }}</div>
                                    <div class="user-email">{{ $order->user->email }}</div>
                                    <div class="user-role {{ $order->user->role === 'admin' ? 'admin' : '' }}">
                                        @if($order->user->role === 'admin')
                                            <i class="mdi mdi-shield-account mr-1"></i> Administrator
                                        @else
                                            <i class="mdi mdi-account mr-1"></i> Employee
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3"><i class="mdi mdi-package-variant mr-2"></i> Order Items</h5>

                            <div class="table-responsive">
                                <table class="order-items-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="product-details">
                                                        <div class="product-image">
                                                            @if($item->product->image)
                                                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}">
                                                            @else
                                                                <i class="mdi mdi-package-variant"></i>
                                                            @endif
                                                        </div>
                                                        <div class="product-name">{{ $item->product->name }}</div>
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
                                            <th class="total-amount">${{ number_format($order->total_amount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    @if(Auth::check() && is_object(Auth::user()) && (Auth::user()->isAdmin() || Auth::id() === $order->user_id))
                        <div class="order-card">
                            <div class="card-header">
                                <h5><i class="mdi mdi-pencil"></i> Update Order Status</h5>
                            </div>
                            <div class="card-body">
                                <!-- Using traditional form submission instead of AJAX -->
                                <form action="{{ route('orders.update', $order) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="status" class="form-label">Order Status</label>
                                        <select name="status" id="status" class="status-select">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn-update-status btn-block">
                                        <i class="mdi mdi-content-save"></i> Update Order
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($order->status !== 'completed' && $order->status !== 'cancelled' && (Auth::user()->isAdmin() || Auth::id() === $order->user_id))
                    <div class="order-card mb-4">
                        <div class="card-header">
                            <h5><i class="mdi mdi-file-document-outline"></i> Purchase Order</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Generate a purchase order document for this order.</p>
                            <a href="{{ route('orders.purchase-order', $order) }}" class="btn-update-status" style="display: inline-block; text-decoration: none; text-align: center;">
                                <i class="mdi mdi-file-pdf-box"></i> Generate Purchase Order
                            </a>
                        </div>
                    </div>
                    @endif



                    <div class="order-card">
                        <div class="card-header">
                            <h5><i class="mdi mdi-information"></i> Order Timeline</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker completed">
                                        <i class="mdi mdi-plus-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Order Created</h6>
                                        <p class="timeline-date">{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                                    </div>
                                </div>

                                @if($order->status !== 'pending')
                                    <div class="timeline-item">
                                        <div class="timeline-marker {{ $order->status !== 'cancelled' ? 'completed' : 'cancelled' }}">
                                            <i class="mdi mdi-progress-clock"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">Processing Started</h6>
                                            <p class="timeline-date">{{ $order->updated_at->format('M d, Y - h:i A') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($order->status === 'completed')
                                    <div class="timeline-item">
                                        <div class="timeline-marker completed">
                                            <i class="mdi mdi-check-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">Order Completed</h6>
                                            <p class="timeline-date">{{ $order->updated_at->format('M d, Y - h:i A') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($order->status === 'cancelled')
                                    <div class="timeline-item">
                                        <div class="timeline-marker cancelled">
                                            <i class="mdi mdi-close-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">Order Cancelled</h6>
                                            <p class="timeline-date">{{ $order->updated_at->format('M d, Y - h:i A') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
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
            // Simple script to scroll to success or error messages
            if ($('.success-alert').length > 0) {
                $('html, body').animate({
                    scrollTop: $('.success-alert').offset().top - 100
                }, 500);
            }

            if ($('.error-alert').length > 0) {
                $('html, body').animate({
                    scrollTop: $('.error-alert').offset().top - 100
                }, 500);
            }
        });
    </script>

    <style>
        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            left: 9px;
            height: 100%;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-marker {
            position: absolute;
            left: -30px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 10px;
        }

        .timeline-marker.completed {
            background-color: #e6f7f0;
            border-color: #02c58d;
            color: #02c58d;
        }

        .timeline-marker.cancelled {
            background-color: #feeef0;
            border-color: #f1556c;
            color: #f1556c;
        }

        .timeline-content {
            padding-bottom: 10px;
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .timeline-date {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 0;
        }
    </style>
</body>
</html>
