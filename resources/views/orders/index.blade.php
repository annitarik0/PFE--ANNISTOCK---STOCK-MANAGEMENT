<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>AnniStock - Orders</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App Icons -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

    <!-- App css -->
    <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
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
                                <h4 class="page-title m-0">Orders</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="float-right d-none d-md-block">
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                        <i class="dripicons-plus"></i> Create New Order
                                    </a>
                                </div>
                            </div>
                        </div>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            @if(Auth::user()->isAdmin())
                                                <th>User</th>
                                            @endif
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                @if(Auth::user()->isAdmin())
                                                    <td>{{ $order->user->name }}</td>
                                                @endif
                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    @if($order->status === 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($order->status === 'processing')
                                                        <span class="badge badge-info">Processing</span>
                                                    @elseif($order->status === 'completed')
                                                        <span class="badge badge-success">Completed</span>
                                                    @elseif($order->status === 'cancelled')
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">
                                                        <i class="dripicons-preview"></i>
                                                    </a>

                                                    @if(Auth::user()->isAdmin())
                                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">
                                                                <i class="dripicons-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ Auth::user()->isAdmin() ? '6' : '5' }}" class="text-center">No orders found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $orders->links() }}
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
</body>
</html>
