@include('components.disable-preloader')
<div class="header-bg">
            <!-- Navigation Bar-->
            <header id="topnav">
                <div class="topbar-main">
                    <div class="container-fluid position-relative">

                        <!-- Logo-->
                        <div class="centered-logo">
                            <a href="{{ route('dashboard') }}" class="logo">
                                <img src="{{asset('backend/assets/images/img2.jpg.png')}}" alt="AnniStock Logo" height="40">
                            </a>
                        </div>
                        <!-- End Logo-->

                        <div class="menu-extras topbar-custom navbar p-0">

                            <ul class="list-inline d-none d-lg-block mb-0">
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        Create New <i class="mdi mdi-plus"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-animated">
                                        @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                            <a class="dropdown-item" href="{{ url('/direct-create-user') }}">New User</a>
                                            <a class="dropdown-item" href="{{ route('products.create')}}">New Product</a>
                                            <a class="dropdown-item" href="{{ route('categories.create')}}">New Category</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ url('/create-order') }}">New Order</a>
                                    </div>
                                </li>
                                <li class="list-inline-item notification-list">
                                    <a href="#" class="nav-link waves-effect">

                                    </a>
                                </li>
                            </ul>

                            <!-- Search icon in the navbar -->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link waves-effect toggle-search" href="#" data-target="#search-wrap">
                                    <i class="mdi mdi-magnify noti-icon"></i>
                                </a>
                                <!-- Search dropdown -->
                                <div class="search-wrap" id="search-wrap">
                                    <div class="search-bar">
                                        <form action="{{ route('search') }}" method="GET" id="search-form">
                                            <input class="search-input" type="search" name="query" placeholder="Search..." autocomplete="off" />
                                            <button type="submit" class="search-submit">
                                                <i class="mdi mdi-magnify"></i>
                                            </button>
                                            <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                                <i class="mdi mdi-close-circle"></i>
                                            </a>
                                        </form>
                                    </div>
                                    <div class="search-results" id="search-results"></div>
                                </div>
                            </li>

                            <ul class="list-inline ml-auto mb-0">



                                <!-- Search icon already added above -->



                                <!-- Notifications -->
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false" id="notificationDropdown">
                                        <i class="mdi mdi-bell-outline noti-icon"></i>
                                        @php
                                            use Illuminate\Support\Str;

                                            // Filter notifications based on user role
                                            // Admin users can see all notifications
                                            // Regular employees should only see notifications not related to user management
                                            if (Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin()) {
                                                $unreadNotifications = \App\Models\Notification::where('is_read', false)
                                                                                          ->orderBy('created_at', 'desc')
                                                                                          ->get();
                                            } else {
                                                // For regular employees, exclude user-related notifications
                                                $unreadNotifications = \App\Models\Notification::where('is_read', false)
                                                                                          ->where(function($query) {
                                                                                              $query->whereNotLike('message', '%user%')
                                                                                                    ->whereNotLike('message', '%User%')
                                                                                                    ->whereNotLike('message', '%account%')
                                                                                                    ->whereNotLike('message', '%Account%');
                                                                                          })
                                                                                          ->orderBy('created_at', 'desc')
                                                                                          ->get();
                                            }
                                            $notificationCount = $unreadNotifications->count();
                                        @endphp
                                        <span class="badge badge-pill noti-icon-badge">{{ $notificationCount }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>Notification ({{ $notificationCount }})</h5>
                                        </div>

                                        @foreach($unreadNotifications as $notification)
                                            <a href="{{ route('notifications.read', $notification->id) }}" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-{{ $notification->type }}">
                                                    @if(Str::contains($notification->message, ['user', 'User', 'account', 'Account']))
                                                        @if($notification->type == 'success')
                                                            <i class="mdi mdi-account-plus"></i>
                                                        @elseif($notification->type == 'danger')
                                                            <i class="mdi mdi-account-remove"></i>
                                                        @elseif($notification->type == 'warning')
                                                            <i class="mdi mdi-account-alert"></i>
                                                        @else
                                                            <i class="mdi mdi-account"></i>
                                                        @endif
                                                    @elseif(Str::contains($notification->message, ['product', 'Product', 'inventory', 'Inventory']))
                                                        @if($notification->type == 'success')
                                                            <i class="mdi mdi-package-variant-plus"></i>
                                                        @elseif($notification->type == 'danger')
                                                            <i class="mdi mdi-package-variant-remove"></i>
                                                        @elseif($notification->type == 'warning')
                                                            <i class="mdi mdi-package-variant-closed-alert"></i>
                                                        @else
                                                            <i class="mdi mdi-package-variant"></i>
                                                        @endif
                                                    @elseif(Str::contains($notification->message, ['order', 'Order']))
                                                        @if($notification->type == 'success')
                                                            <i class="mdi mdi-clipboard-check"></i>
                                                        @elseif($notification->type == 'danger')
                                                            <i class="mdi mdi-clipboard-remove"></i>
                                                        @elseif($notification->type == 'warning')
                                                            <i class="mdi mdi-clipboard-alert"></i>
                                                        @else
                                                            <i class="mdi mdi-clipboard-text"></i>
                                                        @endif
                                                    @else
                                                        <i class="mdi mdi-bell"></i>
                                                    @endif
                                                </div>
                                                <p class="notify-details">
                                                    {{ $notification->message }}
                                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                </p>
                                            </a>
                                        @endforeach

                                        @if($notificationCount == 0)
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <p class="notify-details">No new notifications</p>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                                <!-- User-->
                                <li class="list-inline-item dropdown notification-list nav-user">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        @if(Auth::check())
                                            @if(Auth::user()->image)
                                                <img src="{{ asset(Auth::user()->image) }}" alt="user" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                                            @else
                                                <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #ccc; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-weight: bold;">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="d-none d-md-inline-block ml-1"> {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i> </span>
                                        @else
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #ccc; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-weight: bold;">
                                                <i class="mdi mdi-account"></i>
                                            </div>
                                            <span class="d-none d-md-inline-block ml-1">Guest <i class="mdi mdi-chevron-down"></i> </span>
                                        @endif
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                        @if(Auth::check())
                                            <a class="dropdown-item" href="{{ route('profile.edit')}}"><i class="dripicons-user text-muted"></i>
                                                @if(app()->getLocale() == 'fr') Profil @else Profile @endif
                                            </a>
                                            @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                                <a class="dropdown-item" href="{{ route('users.index')}}"><i class="dripicons-gear text-muted"></i>
                                                    @if(app()->getLocale() == 'fr') Gestion des utilisateurs @else Manage Users @endif
                                                </a>
                                            @endif
                                            <a class="dropdown-item" href="{{ route('orders.my')}}"><i class="dripicons-document text-muted"></i>
                                                @if(app()->getLocale() == 'fr') Mes commandes @else My Orders @endif
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                                    Logout
                                                </x-dropdown-link>
                                            </form>
                                        @else
                                            <a class="dropdown-item" href="{{ route('login') }}"><i class="dripicons-user text-muted"></i>
                                                Login
                                            </a>
                                            <a class="dropdown-item" href="{{ route('register') }}"><i class="dripicons-gear text-muted"></i>
                                                Register
                                            </a>
                                        @endif
                                    </div>
                                </li>
                                <li class="menu-item list-inline-item">
                                    <!-- Mobile menu toggle-->
                                    <a class="navbar-toggle nav-link">
                                        <div class="lines">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </a>
                                    <!-- End mobile menu toggle-->
                                </li>

                            </ul>

                        </div>
                        <!-- end menu-extras -->

                        <div class="clearfix"></div>

                    </div> <!-- end container -->
                </div>
                <!-- end topbar-main -->

                <!-- MENU Start -->
                <div class="navbar-custom">
                    <div class="container-fluid">

                        <div id="navigation" class="centered-nav">

                            <!-- Navigation Menu-->
                            <ul class="navigation-menu">

                                <li class="has-submenu">
                                    <a href="{{ route('dashboard')}}"><i class="dripicons-home"></i>
                                        Dashboard
                                    </a>
                                </li>

                                @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                    <li class="has-submenu">
                                        <a href="{{ route('users.index') }}"><i class="dripicons-user-group"></i>
                                            Users
                                        </a>
                                    </li>
                                @endif

                                <li class="has-submenu">
                                    <a href="{{ route('products.index') }}"><i class="dripicons-store"></i>
                                        Products
                                    </a>
                                </li>

                                @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                                    <li class="has-submenu">
                                        <a href="{{ route('categories.index') }}"><i class="dripicons-tags"></i>
                                            Categories
                                        </a>
                                    </li>
                                @endif

                                <li class="has-submenu">
                                    <a href="#"><i class="dripicons-cart"></i>
                                        Orders
                                        <div class="arrow-down"></div>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('orders.index') }}">
                                            All Orders
                                        </a></li>
                                        <li><a href="{{ route('orders.my') }}">
                                            My Orders
                                        </a></li>
                                    </ul>
                                </li>
            </header>
            <!-- End Navigation Bar-->



        </div>
        <!-- header-bg -->

    <!-- Remove this session alert that appears under the navbar -->
    <!-- @session("success")
    <div class="alert alert-success">{{ $value }}</div>
    @endsession -->

    <!-- Add custom CSS for the logo in the header and dashboard cards -->
    <style>
        /* Language Switcher Styling */
        .dropdown-item.active {
            background-color: rgba(75, 108, 183, 0.1);
            color: #4b6cb7;
        }

        .dropdown-header {
            font-weight: 600;
            color: #4b6cb7;
            background-color: rgba(75, 108, 183, 0.05);
            padding: 8px 16px;
        }

        /* Dashboard Card Styling - Matching Admin Dashboard Cards */
        .card.bg-primary,
        .card.bg-info,
        .card.bg-pink,
        .card.bg-success {
            border: none;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card.bg-primary:hover,
        .card.bg-info:hover,
        .card.bg-pink:hover,
        .card.bg-success:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .mini-stat {
            position: relative;
        }

        .mini-stat-desc {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mini-stat-desc h6 {
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 0;
            letter-spacing: 0.5px;
        }

        .mini-stat-desc h4 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .badge-light {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .mini-stat p {
            font-size: 14px;
            margin-bottom: 0;
        }

        .mini-stat small {
            font-size: 11px;
            opacity: 0.8;
        }

        .bg-primary {
            background-color: #4e73df !important;
        }

        .bg-info {
            background-color: #36b9cc !important;
        }

        .bg-pink {
            background-color: #e83e8c !important;
        }

        .bg-success {
            background-color: #1cc88a !important;
        }

        .text-white {
            color: #fff !important;
        }

        .float-left {
            float: left !important;
        }

        .float-right {
            float: right !important;
        }

        .clearfix::after {
            display: block;
            clear: both;
            content: "";
        }

        .font-14 {
            font-size: 14px !important;
        }

        .font-12 {
            font-size: 12px !important;
        }

        .m-0 {
            margin: 0 !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mt-0 {
            margin-top: 0 !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .ml-2 {
            margin-left: 0.5rem !important;
        }

        .mr-1 {
            margin-right: 0.25rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .d-block {
            display: block !important;
        }

        .d-flex {
            display: flex !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        /* Card under navbar styling */
        .navbar-card {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Logo styling */
        .logo img {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
            max-height: 40px;
            width: auto;
            vertical-align: middle;
        }

        .logo:hover img {
            transform: scale(1.05);
        }

        .topbar-main .logo {
            display: flex;
            align-items: center;
            height: 70px;
        }

        /* Center logo in topbar */
        .container-fluid.position-relative {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .centered-logo {
            position: absolute;
            left: 10%;
            transform: translateX(-50%);
            z-index: 10;
        }

        /* Adjust other elements to maintain their positions */
        .menu-extras {
            margin-left: auto;
        }

        .topbar-main .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Ensure the dropdown menus appear above the logo */
        .dropdown-menu {
            z-index: 20;
        }



        .mdi-loading.mdi-spin {
            animation: mdi-spin 1s infinite linear;
        }

        @keyframes mdi-spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Enhanced Search Bar Styling */
        .search-wrap {
            position: absolute;
            top: 70px;
            right: 0;
            width: 400px;
            background-color: #fff;
            z-index: 999;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-right: 15px;
            transform: translateY(-10px);
            overflow: hidden;
        }

        .search-wrap.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Search results styling */
        .search-results {
            max-height: 500px;
            overflow-y: auto;
            padding: 0;
            margin: 0;
            border-top: 1px solid #f1f1f1;
        }

        .search-result-item {
            display: flex;
            padding: 12px 15px;
            border-bottom: 1px solid #f1f1f1;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #333;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
            text-decoration: none;
        }

        .search-result-icon {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            background-color: #f1f3f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .search-result-image {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            overflow: hidden;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .search-result-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .search-result-icon.product {
            background-color: rgba(78, 115, 223, 0.1);
            color: #4e73df;
        }

        .search-result-icon.category {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .search-result-icon.order {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .search-result-icon.user {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .search-result-content {
            flex-grow: 1;
            min-width: 0;
        }

        .search-result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .search-result-title {
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #333;
            margin-right: 8px;
        }

        .search-result-subtitle {
            font-size: 12px;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 4px;
        }

        .search-result-badge {
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: 500;
        }

        .search-result-details {
            display: flex;
            flex-wrap: wrap;
            margin-top: 4px;
            font-size: 11px;
        }

        .search-result-detail {
            margin-right: 12px;
            color: #6c757d;
        }

        .search-result-detail strong {
            color: #495057;
        }

        .search-no-results {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }

        .search-bar {
            position: relative;
            width: 100%;
            background-color: #fff;
            overflow: hidden;
        }

        .search-bar form {
            display: flex;
            align-items: center;
            width: 100%;
            background-color: #fff;
            border-bottom: 1px solid #eaeaea;
        }

        .search-input {
            background-color: transparent;
            border: none;
            color: #333;
            padding: 12px 15px;
            width: 100%;
            font-size: 14px;
            outline: none;
        }

        .search-input::placeholder {
            color: #aaa;
            font-weight: 300;
        }

        .search-submit {
            background: transparent;
            border: none;
            color: #4e73df;
            cursor: pointer;
            padding: 0 10px;
            font-size: 16px;
            transition: color 0.2s ease;
            flex-shrink: 0;
            height: 40px;
            display: flex;
            align-items: center;
        }

        .search-submit:hover {
            color: #2e59d9;
        }

        .close-search {
            color: #888;
            padding: 0 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            transition: color 0.2s ease;
            height: 40px;
        }

        .close-search:hover {
            color: #333;
        }

        /* Search Results Dropdown */
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            border-radius: 0 0 4px 4px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            border-top: 1px solid #eaeaea;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-results.active {
            opacity: 1;
            visibility: visible;
        }

        .search-result-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease;
            text-decoration: none;
            color: #333;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-icon {
            margin-right: 12px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            color: #fff;
            flex-shrink: 0;
            font-size: 14px;
        }

        .search-result-icon.product {
            background-color: #4e73df;
        }

        .search-result-icon.category {
            background-color: #1cc88a;
        }

        .search-result-icon.order {
            background-color: #e74a3b;
        }

        .search-result-icon.user {
            background-color: #f6c23e;
        }

        .search-result-content {
            flex-grow: 1;
        }

        .search-result-title {
            font-weight: 500;
            color: #333;
            margin-bottom: 2px;
            font-size: 14px;
        }

        .search-result-subtitle {
            font-size: 12px;
            color: #888;
        }

        .search-no-results {
            padding: 15px;
            text-align: center;
            color: #888;
            font-size: 14px;
            font-weight: 300;
        }

        /* Center navigation menu */
        .centered-nav {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .navigation-menu {
            display: flex;
            justify-content: center;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .search-wrap {
                top: 60px;
                padding: 10px;
            }

            .search-input {
                font-size: 14px;
                padding: 10px 15px;
            }

            .centered-nav {
                justify-content: flex-start;
            }
        }
    </style>

    <!-- Add JavaScript for search functionality and notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notification handling
            const notificationDropdown = document.getElementById('notificationDropdown');
            let hasOpened = false;

            if (notificationDropdown) {
                notificationDropdown.addEventListener('click', function(e) {
                    // Only mark as read the first time the dropdown is opened in a session
                    if (!hasOpened && {{ $notificationCount }} > 0) {
                        hasOpened = true;

                        // Send AJAX request to mark all notifications as read
                        fetch('{{ route("notifications.markAllRead") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            credentials: 'same-origin'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the notification count badge
                                const badge = document.querySelector('.noti-icon-badge');
                                if (badge) {
                                    badge.textContent = '0';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error marking notifications as read:', error);
                        });
                    }
                });
            }

            // Search functionality
            const searchInput = document.querySelector('.search-input');
            const searchResults = document.getElementById('search-results');
            const searchForm = document.getElementById('search-form');
            const searchWrap = document.getElementById('search-wrap');
            const toggleSearch = document.querySelectorAll('.toggle-search');

            // Toggle search bar visibility with clean animation
            toggleSearch.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-target');
                    const targetElement = document.querySelector(target);

                    if (targetElement) {
                        if (!targetElement.classList.contains('active')) {
                            // Opening the search bar
                            targetElement.classList.add('active');

                            // Focus the search input after a short delay
                            setTimeout(() => {
                                searchInput.focus();
                            }, 100);
                        } else {
                            // Closing the search bar
                            searchResults.classList.remove('active');
                            targetElement.classList.remove('active');
                            searchInput.value = '';
                            searchResults.innerHTML = '';
                        }
                    }
                });
            });

            // Close search when pressing Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && searchWrap.classList.contains('active')) {
                    searchResults.classList.remove('active');
                    searchWrap.classList.remove('active');
                    searchInput.value = '';
                    searchResults.innerHTML = '';
                }
            });

            // Add keyboard navigation for search results
            document.addEventListener('keydown', function(e) {
                if (!searchWrap.classList.contains('active')) return;

                const results = searchResults.querySelectorAll('.search-result-item');
                if (results.length === 0) return;

                // Find the currently focused result
                const focusedResult = Array.from(results).findIndex(result =>
                    result === document.activeElement || result.matches(':focus-within'));

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const nextIndex = focusedResult < 0 ? 0 : (focusedResult + 1) % results.length;
                    results[nextIndex].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prevIndex = focusedResult < 0 ? results.length - 1 :
                        (focusedResult - 1 + results.length) % results.length;
                    results[prevIndex].focus();
                }
            });

            // Live search functionality with minimalist style
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                // Clear previous timeout
                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    searchResults.classList.remove('active');
                    return;
                }

                // Set a timeout to avoid making too many requests while typing
                searchTimeout = setTimeout(() => {
                    // Show loading indicator
                    searchResults.innerHTML = '<div class="search-no-results">Searching...</div>';
                    searchResults.classList.add('active');

                    // Sanitize the query before sending
                    const sanitizedQuery = query.replace(/[^\w\s]/gi, '');

                    // Add CSRF token for security
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Make AJAX request to search endpoint with improved security
                    fetch(`{{ route('api.search') }}?query=${encodeURIComponent(sanitizedQuery)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Prepare content
                        let newContent = '';

                        if (data.results && data.results.length > 0) {
                            // Create results HTML
                            data.results.forEach(result => {
                                let iconClass = 'mdi-help-circle';
                                let iconType = '';

                                // Determine icon based on result type
                                if (result.type === 'product') {
                                    iconClass = 'mdi-package-variant';
                                    iconType = 'product';
                                } else if (result.type === 'category') {
                                    iconClass = 'mdi-tag-multiple';
                                    iconType = 'category';
                                } else if (result.type === 'order') {
                                    iconClass = 'mdi-clipboard-text';
                                    iconType = 'order';
                                } else if (result.type === 'user') {
                                    iconClass = 'mdi-account';
                                    iconType = 'user';
                                }

                                // Create enhanced search result item with badges and images
                                let badgeHtml = '';
                                if (result.badge) {
                                    badgeHtml = `<span class="search-result-badge badge badge-${result.badge.class}">${result.badge.text}</span>`;
                                }

                                let imageHtml = '';
                                if (result.image) {
                                    imageHtml = `<div class="search-result-image"><img src="${result.image}" alt="${result.title}"></div>`;
                                } else {
                                    imageHtml = `<div class="search-result-icon ${iconType}"><i class="mdi ${iconClass}"></i></div>`;
                                }

                                // Create details section if available
                                let detailsHtml = '';
                                if (result.details) {
                                    let detailsContent = '';

                                    if (result.type === 'product') {
                                        detailsContent = `
                                            <div class="search-result-detail"><strong>Price:</strong> ${result.details.price}</div>
                                            <div class="search-result-detail"><strong>Quantity:</strong> ${result.details.quantity}</div>
                                        `;
                                    } else if (result.type === 'order') {
                                        detailsContent = `
                                            <div class="search-result-detail"><strong>Date:</strong> ${result.details.date}</div>
                                            <div class="search-result-detail"><strong>Total:</strong> ${result.details.total}</div>
                                        `;
                                    } else if (result.type === 'user') {
                                        detailsContent = `
                                            <div class="search-result-detail"><strong>Email:</strong> ${result.details.email}</div>
                                            <div class="search-result-detail"><strong>Joined:</strong> ${result.details.joined}</div>
                                        `;
                                    } else if (result.type === 'category') {
                                        detailsContent = `
                                            <div class="search-result-detail"><strong>Products:</strong> ${result.details.productCount}</div>
                                        `;
                                    }

                                    detailsHtml = `<div class="search-result-details">${detailsContent}</div>`;
                                }

                                newContent += `
                                    <a href="${result.url}" class="search-result-item">
                                        ${imageHtml}
                                        <div class="search-result-content">
                                            <div class="search-result-header">
                                                <div class="search-result-title">${result.title}</div>
                                                ${badgeHtml}
                                            </div>
                                            <div class="search-result-subtitle">${result.subtitle}</div>
                                            ${detailsHtml}
                                        </div>
                                    </a>
                                `;
                            });
                        } else {
                            // No results found
                            newContent = '<div class="search-no-results">No results found for "' + query + '"</div>';
                        }

                        // Update results
                        searchResults.innerHTML = newContent;
                        searchResults.classList.add('active');
                    })
                    .catch(error => {
                        console.error('Error performing search:', error);

                        // Log the error for monitoring
                        fetch('/log-js-error', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                error: error.message,
                                location: 'search',
                                query: sanitizedQuery
                            })
                        }).catch(e => console.error('Error logging:', e));

                        // Show a more user-friendly error message
                        searchResults.innerHTML = '<div class="search-no-results">' +
                            '<i class="mdi mdi-alert-circle-outline text-warning mr-2"></i>' +
                            'No results found for "' + sanitizedQuery + '"</div>';
                        searchResults.classList.add('active');
                    });
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchWrap.contains(e.target) && !e.target.classList.contains('toggle-search')) {
                    searchResults.classList.remove('active');
                }
            });

            // Handle form submission
            searchForm.addEventListener('submit', function(e) {
                const query = searchInput.value.trim();
                if (query.length < 2) {
                    e.preventDefault();
                }
            });

        });
    </script>
