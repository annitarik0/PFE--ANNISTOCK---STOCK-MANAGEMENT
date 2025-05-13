<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>AnniStock - {{ isset($title) ? $title : 'Orders Management' }}</title>
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
        .orders-container {
            padding: 30px 0;
        }

        .orders-header {
            margin-bottom: 30px;
        }

        .orders-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .orders-title i {
            color: #4b6cb7;
            margin-right: 10px;
            font-size: 28px;
        }

        .orders-subtitle {
            color: #6c757d;
            margin-bottom: 0;
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
        }

        .filter-bar label {
            font-weight: 600;
            color: #4b6cb7;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .filter-bar select, .filter-bar input {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            background-color: white;
            width: 100%;
            font-size: 14px;
            color: #495057;
        }

        .filter-bar select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234b6cb7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }

        .filter-bar select:focus, .filter-bar input:focus {
            outline: none;
            border-color: #4b6cb7;
            box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
        }

        .filter-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .filter-title i {
            margin-right: 8px;
            color: #4b6cb7;
        }

        .filter-reset {
            color: #4b6cb7;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            margin-left: auto;
        }

        .filter-reset i {
            margin-right: 5px;
            font-size: 16px;
        }

        .filter-reset:hover {
            color: #3a5aa0;
            text-decoration: none;
        }

        .order-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .order-header {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .order-id {
            font-weight: 600;
            color: #4b6cb7;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .order-id i {
            margin-right: 8px;
            font-size: 18px;
        }

        .order-date {
            color: #6c757d;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .order-date i {
            margin-right: 5px;
            font-size: 16px;
        }

        .order-body {
            padding: 20px;
            background-color: white;
        }

        .order-info {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .order-info-item {
            flex: 1;
            min-width: 150px;
            margin-bottom: 15px;
        }

        .order-info-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .order-status {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-pending {
            background-color: rgba(255, 190, 11, 0.15);
            color: #ffbe0b;
        }

        .status-processing {
            background-color: rgba(56, 164, 248, 0.15);
            color: #38a4f8;
        }

        .status-completed {
            background-color: rgba(2, 197, 141, 0.15);
            color: #02c58d;
        }

        .status-cancelled {
            background-color: rgba(241, 85, 108, 0.15);
            color: #f1556c;
        }

        .order-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
            gap: 8px; /* Consistent spacing between buttons */
        }

        .btn-view, .btn-delete {
            color: white;
            border-radius: 6px;
            padding: 7px 12px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            min-width: 110px; /* Fixed width for both buttons */
            height: 34px; /* Fixed height for consistency */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background-color: #4b6cb7;
        }

        .btn-delete {
            background-color: #f1556c;
        }

        .btn-view i, .btn-delete i {
            margin-right: 5px;
            font-size: 15px;
        }

        .btn-view:hover, .btn-delete:hover {
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .btn-view:hover {
            background-color: #3a5aa0;
        }

        .btn-delete:hover {
            background-color: #e63e57;
        }

        .pagination-container {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .empty-orders {
            text-align: center;
            padding: 50px 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin: 30px 0;
        }

        .empty-orders i {
            font-size: 48px;
            color: #adb5bd;
            margin-bottom: 20px;
            display: block;
        }

        .empty-orders h3 {
            font-size: 20px;
            color: #495057;
            margin-bottom: 10px;
        }

        .empty-orders p {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .btn-create-order {
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

        .btn-create-order i {
            margin-right: 8px;
            font-size: 18px;
        }

        .btn-create-order:hover {
            background-color: #3a5aa0;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Fade transition for filtering */
        .fade-transition {
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }

        /* Debug info */
        .debug-info {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-family: monospace;
            font-size: 12px;
            color: #495057;
            display: none;
        }

        .debug-info pre {
            margin: 0;
            white-space: pre-wrap;
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

    <div class="orders-container">
        <div class="container">
            <div class="orders-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="orders-title">
                            <i class="mdi mdi-clipboard-text-outline"></i> {{ isset($title) ? $title : 'Orders Management' }}
                        </h1>
                        <p class="orders-subtitle">{{ isset($description) ? $description : 'View and manage all orders in the system' }}</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ url('/create-order') }}" class="btn-create-order">
                            <i class="mdi mdi-plus-circle"></i> Create New Order
                        </a>
                    </div>
                </div>
            </div>

            <div class="filter-bar">
                <div class="filter-title">
                    <i class="mdi mdi-filter-variant"></i> Filter Orders
                    <a href="javascript:void(0)" id="reset-filters" class="filter-reset">
                        <i class="mdi mdi-refresh"></i> Reset Filters
                    </a>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status-filter">
                                <i class="mdi mdi-tag-outline mr-1"></i> Status
                            </label>
                            <select id="status-filter">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date-filter">
                                <i class="mdi mdi-calendar mr-1"></i> Date Range
                            </label>
                            <select id="date-filter">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sort-by">
                                <i class="mdi mdi-sort mr-1"></i> Sort By
                            </label>
                            <select id="sort-by">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="amount-high">Amount: High to Low</option>
                                <option value="amount-low">Amount: Low to High</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="orders-list">
                @forelse($orders as $order)
                    <div class="order-card"
                         data-status="{{ $order->status }}"
                         data-date="{{ $order->created_at->format('Y-m-d') }}"
                         data-amount="{{ $order->total_amount }}"
                         data-id="{{ $order->id }}"
                         data-items="{{ $order->items->count() }}"
                         data-timestamp="{{ $order->created_at->timestamp }}"
                         data-user="{{ $order->user_id }}"
                    >
                        <div class="order-header">
                            <div class="order-id">
                                <i class="mdi mdi-shopping"></i> {{ $order->getDisplayName() }}
                            </div>
                            <div class="order-date">
                                <i class="mdi mdi-calendar-clock"></i> {{ $order->created_at->format('M d, Y - h:i A') }}
                            </div>
                        </div>
                        <div class="order-body">
                            <div class="order-info">
                                <div class="order-info-item">
                                    <div class="order-info-label">Status</div>
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
                                    <div class="order-info-label">Total Amount</div>
                                    <div class="order-info-value">${{ number_format($order->total_amount, 2) }}</div>
                                </div>
                                <div class="order-info-item">
                                    <div class="order-info-label">Items</div>
                                    <div class="order-info-value">{{ $order->items->count() }} items</div>
                                </div>
                                @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                <div class="order-info-item">
                                    <div class="order-info-label">User</div>
                                    <div class="order-info-value">{{ $order->user->name }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="order-actions">
                                <a href="{{ route('orders.show', $order) }}" class="btn-view">
                                    <i class="mdi mdi-eye"></i> View Details
                                </a>

                                @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this order?')">
                                            <i class="mdi mdi-delete"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-orders">
                        <i class="mdi mdi-clipboard-text-outline"></i>
                        <h3>No Orders Found</h3>
                        @if(isset($isMyOrders) && $isMyOrders)
                            <p>You haven't created any orders yet.</p>
                            <a href="{{ url('/create-order') }}" class="btn-create-order">
                                <i class="mdi mdi-plus-circle"></i> Create Your First Order
                            </a>
                        @else
                            <p>There are no orders in the system yet.</p>
                            <a href="{{ url('/create-order') }}" class="btn-create-order">
                                <i class="mdi mdi-plus-circle"></i> Create New Order
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <div class="pagination-container">
                {{ $orders->links() }}
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
            // Add debug info to console
            console.log('Orders page loaded');
            console.log('Total orders: ' + $('.order-card').length);

            // Log data attributes for debugging
            $('.order-card').each(function(index) {
                console.log('Order #' + $(this).data('id') + ' - Status: ' + $(this).data('status') +
                            ', Date: ' + $(this).data('date') + ', Amount: ' + $(this).data('amount'));
            });

            // Status filter
            $('#status-filter').on('change', function() {
                console.log('Status filter changed to: ' + $(this).val());
                filterOrders();
            });

            // Date filter
            $('#date-filter').on('change', function() {
                console.log('Date filter changed to: ' + $(this).val());
                filterOrders();
            });

            // Sort by
            $('#sort-by').on('change', function() {
                console.log('Sort filter changed to: ' + $(this).val());
                filterOrders();
            });

            // Reset filters
            $('#reset-filters').on('click', function() {
                console.log('Filters reset');
                $('#status-filter').val('');
                $('#date-filter').val('');
                $('#sort-by').val('newest');
                filterOrders();
            });

            function filterOrders() {
                const statusFilter = $('#status-filter').val();
                const dateFilter = $('#date-filter').val();
                const sortBy = $('#sort-by').val();

                console.log('Filtering orders - Status: ' + statusFilter + ', Date: ' + dateFilter + ', Sort: ' + sortBy);

                // Show all orders first
                $('.order-card').show();

                // Apply status filter
                if (statusFilter) {
                    $('.order-card').each(function() {
                        const cardStatus = $(this).data('status');
                        if (cardStatus !== statusFilter) {
                            $(this).hide();
                            console.log('Hiding order #' + $(this).data('id') + ' - status mismatch: ' + cardStatus + ' vs ' + statusFilter);
                        }
                    });
                }

                // Apply date filter
                if (dateFilter) {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const weekStart = new Date(today);
                    weekStart.setDate(today.getDate() - today.getDay());

                    const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                    const yearStart = new Date(today.getFullYear(), 0, 1);

                    console.log('Date ranges - Today: ' + today.toISOString().split('T')[0] +
                                ', Week start: ' + weekStart.toISOString().split('T')[0] +
                                ', Month start: ' + monthStart.toISOString().split('T')[0] +
                                ', Year start: ' + yearStart.toISOString().split('T')[0]);

                    $('.order-card:visible').each(function() {
                        const orderDateStr = $(this).data('date');
                        const orderDate = new Date(orderDateStr);
                        orderDate.setHours(0, 0, 0, 0);

                        console.log('Checking order #' + $(this).data('id') + ' date: ' + orderDateStr);

                        let hideOrder = false;

                        if (dateFilter === 'today' && orderDate.toISOString().split('T')[0] !== today.toISOString().split('T')[0]) {
                            hideOrder = true;
                            console.log('Hiding - not today');
                        } else if (dateFilter === 'week' && orderDate < weekStart) {
                            hideOrder = true;
                            console.log('Hiding - not this week');
                        } else if (dateFilter === 'month' && orderDate < monthStart) {
                            hideOrder = true;
                            console.log('Hiding - not this month');
                        } else if (dateFilter === 'year' && orderDate < yearStart) {
                            hideOrder = true;
                            console.log('Hiding - not this year');
                        }

                        if (hideOrder) {
                            $(this).hide();
                        }
                    });
                }

                // Apply sorting
                const $ordersList = $('#orders-list');
                const $orders = $('.order-card:visible').detach();

                console.log('Sorting ' + $orders.length + ' visible orders');

                $orders.sort(function(a, b) {
                    const $a = $(a);
                    const $b = $(b);

                    if (sortBy === 'newest') {
                        // Use timestamp for more accurate sorting
                        return $b.data('timestamp') - $a.data('timestamp');
                    } else if (sortBy === 'oldest') {
                        return $a.data('timestamp') - $b.data('timestamp');
                    } else if (sortBy === 'amount-high') {
                        return parseFloat($b.data('amount')) - parseFloat($a.data('amount'));
                    } else if (sortBy === 'amount-low') {
                        return parseFloat($a.data('amount')) - parseFloat($b.data('amount'));
                    }

                    return 0;
                });

                $ordersList.append($orders);

                // Show empty state if no orders visible
                if ($('.order-card:visible').length === 0) {
                    console.log('No orders visible after filtering');

                    if ($('#no-orders-message').length === 0) {
                        $ordersList.append(`
                            <div id="no-orders-message" class="empty-orders">
                                <i class="mdi mdi-filter-remove"></i>
                                <h3>No Orders Match Your Filters</h3>
                                <p>Try changing your filter criteria or reset filters to see all orders.</p>
                                <a href="javascript:void(0)" id="clear-filters" class="btn-create-order">
                                    <i class="mdi mdi-refresh"></i> Reset Filters
                                </a>
                            </div>
                        `);

                        $('#clear-filters').on('click', function() {
                            $('#reset-filters').click();
                        });
                    }
                } else {
                    $('#no-orders-message').remove();
                }

                // Update count
                updateOrderCount();
            }

            function updateOrderCount() {
                const visibleCount = $('.order-card:visible').length;
                const totalCount = $('.order-card').length;

                console.log('Updating count: ' + visibleCount + ' of ' + totalCount + ' orders visible');

                $('.orders-subtitle').html(`Showing <strong>${visibleCount}</strong> of <strong>${totalCount}</strong> orders`);
            }

            // Initialize
            updateOrderCount();

            // Add animation to filter changes
            $('.filter-bar select').on('change', function() {
                $('#orders-list').addClass('fade-transition');
                setTimeout(function() {
                    $('#orders-list').removeClass('fade-transition');
                }, 300);
            });
        });
    </script>
</body>
</html>
