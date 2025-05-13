<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>AnniStock - Dashboard</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{asset('backend/assets/images/img2.jpg.png')}}">

        <!-- morris css -->
        <link rel="stylesheet" href="../plugins/morris/morris.css">

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

                @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                <!-- Admin Dashboard Header - Comprehensive -->
                <div class="enterprise-dashboard-header mb-4">
                    <div class="header-overlay"></div>
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <div class="dashboard-header-content">
                                    <div class="dashboard-logo">
                                        <div class="logo-icon custom-logo">
                                            <img src="{{asset('backend/assets/images/img2.jpg.png')}}" alt="AnniStock Logo" class="logo-image">
                                        </div>
                                        <div class="logo-text">
                                            <span>ANNISTOCK</span>
                                            <small>Enterprise Analytics</small>
                                        </div>
                                    </div>
                                    <h1 class="dashboard-heading">Executive Dashboard</h1>
                                    <div class="dashboard-metrics">
                                        <div class="metric">
                                            <div class="metric-icon"><i class="mdi mdi-account-group"></i></div>
                                            <div class="metric-data">
                                                <span class="metric-value">{{ $userCount }}</span>
                                                <span class="metric-label">Users</span>
                                            </div>
                                        </div>

                                        <div class="metric">
                                            <div class="metric-icon"><i class="mdi mdi-package-variant"></i></div>
                                            <div class="metric-data">
                                                <span class="metric-value">{{ $productCount }}</span>
                                                <span class="metric-label">Products</span>
                                            </div>
                                        </div>

                                        <div class="metric">
                                            <div class="metric-icon"><i class="mdi mdi-cart-outline"></i></div>
                                            <div class="metric-data">
                                                <span class="metric-value">{{ $orderCount }}</span>
                                                <span class="metric-label">Orders</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="dashboard-header-sidebar">
                                    <div class="user-welcome">
                                        <div class="user-avatar">
                                            <i class="mdi mdi-account-circle"></i>
                                            <span class="status-indicator"></span>
                                        </div>
                                        <div class="user-info">
                                            <h4>Welcome back, {{ Auth::user()->name }}</h4>
                                            <p>Administrator Account</p>
                                        </div>
                                    </div>
                                    <div class="dashboard-actions">
                                        <div class="action-item">
                                            <i class="mdi mdi-refresh"></i>
                                            <span>Last updated: {{ now()->format('h:i A') }}</span>
                                        </div>
                                        <div class="action-item">
                                            <i class="mdi mdi-calendar"></i>
                                            <span>{{ now()->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- Employee Dashboard Header with TARIK CARD STYLE (without outer container) -->
                <div class="enterprise-dashboard-header">
                    <div class="header-overlay"></div>
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <div class="dashboard-header-content">
                                    <div class="dashboard-logo">
                                        <div class="logo-icon custom-logo">
                                            <img src="{{asset('backend/assets/images/img2.jpg.png')}}" alt="AnniStock Logo" class="logo-image">
                                        </div>
                                        <div class="logo-text">
                                            <span>ANNISTOCK</span>
                                            <small>Employee Portal</small>
                                        </div>
                                    </div>
                                    <h1 class="dashboard-heading">Employee Space</h1>
                                    <div class="dashboard-metrics">
                                        <div class="metric">
                                            <div class="metric-icon"><i class="mdi mdi-package-variant"></i></div>
                                            <div class="metric-data">
                                                <span class="metric-value">{{ $productCount }}</span>
                                                <span class="metric-label">Products</span>
                                            </div>
                                        </div>

                                        <div class="metric">
                                            <div class="metric-icon"><i class="mdi mdi-clipboard-text-outline"></i></div>
                                            <div class="metric-data">
                                                <span class="metric-value">{{ Auth::user()->orders->count() }}</span>
                                                <span class="metric-label">My Orders</span>
                                            </div>
                                        </div>

                                        <div class="metric">
                                            <div class="metric-icon"><i class="mdi mdi-cart-outline"></i></div>
                                            <div class="metric-data">
                                                <span class="metric-value">{{ Auth::user()->orders->where('status', 'completed')->count() }}</span>
                                                <span class="metric-label">Completed</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="dashboard-header-sidebar">
                                    <div class="user-welcome">
                                        <div class="user-avatar">
                                            <i class="mdi mdi-account-circle"></i>
                                            <span class="status-indicator"></span>
                                        </div>
                                        <div class="user-info">
                                            <h4>Welcome back, {{ Auth::user()->name }}</h4>
                                            <p>Employee Account</p>
                                        </div>
                                    </div>
                                    <div class="dashboard-actions">
                                        <div class="action-item">
                                            <i class="mdi mdi-refresh"></i>
                                            <span>Last updated: {{ now()->format('h:i A') }}</span>
                                        </div>
                                        <div class="action-item">
                                            <i class="mdi mdi-calendar"></i>
                                            <span>{{ now()->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gradient Header Card Styling -->
                <style>
                    .gradient-welcome-card {
                        border: none;
                        border-radius: 10px;
                        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
                        color: white !important;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                    }

                    /* Fix text visibility in gradient cards */
                    .gradient-welcome-card .text-white {
                        color: white !important;
                    }

                    .gradient-welcome-card .text-white-50 {
                        color: rgba(255, 255, 255, 0.8) !important;
                    }

                    /* Fix all text visibility in gradient cards */
                    .gradient-welcome-card * {
                        color: white !important;
                    }

                    .gradient-welcome-card small,
                    .gradient-welcome-card .text-white-50,
                    .gradient-welcome-card p.text-white-50 {
                        color: rgba(255, 255, 255, 0.8) !important;
                    }

                    .gradient-welcome-card .progress-bar {
                        color: white !important;
                    }

                    .gradient-welcome-card table td,
                    .gradient-welcome-card table th {
                        color: white !important;
                    }

                    .gradient-welcome-card table tr {
                        background-color: rgba(255, 255, 255, 0.05) !important;
                    }

                    .gradient-welcome-card table thead tr {
                        background-color: rgba(255, 255, 255, 0.1) !important;
                    }

                    /* Fix specific elements */
                    .gradient-welcome-card .badge {
                        color: inherit !important;
                    }

                    .gradient-welcome-card .btn-light,
                    .gradient-welcome-card .btn-xs {
                        color: #4b6cb7 !important;
                    }

                    /* Increase visibility of panels */
                    .gradient-welcome-card .p-3.rounded {
                        background-color: rgba(255, 255, 255, 0.2) !important;
                    }

                    /* Increase contrast for text */
                    .gradient-welcome-card h4,
                    .gradient-welcome-card h5,
                    .gradient-welcome-card .text-white,
                    .gradient-welcome-card td,
                    .gradient-welcome-card th {
                        color: white !important;
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
                    }

                    /* Badge soft styles */
                    .badge-soft-success {
                        background-color: rgba(2, 197, 141, 0.15);
                        color: #02c58d;
                        font-weight: 500;
                        padding: 5px 10px;
                    }

                    .badge-soft-warning {
                        background-color: rgba(255, 190, 11, 0.15);
                        color: #ffbe0b;
                        font-weight: 500;
                        padding: 5px 10px;
                    }

                    .badge-soft-info {
                        background-color: rgba(56, 164, 248, 0.15);
                        color: #38a4f8;
                        font-weight: 500;
                        padding: 5px 10px;
                    }

                    .badge-soft-danger {
                        background-color: rgba(241, 85, 108, 0.15);
                        color: #f1556c;
                        font-weight: 500;
                        padding: 5px 10px;
                    }

                    /* Card shadow styles */
                    .shadow-sm {
                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
                    }

                    /* Background soft styles */
                    .bg-soft-primary {
                        background-color: rgba(78, 158, 255, 0.2) !important;
                    }

                    .bg-soft-success {
                        background-color: rgba(2, 197, 141, 0.2) !important;
                    }

                    .bg-soft-info {
                        background-color: rgba(56, 164, 248, 0.2) !important;
                    }

                    .text-primary {
                        color: #4e9eff !important;
                    }

                    .text-success {
                        color: #02c58d !important;
                    }

                    .text-info {
                        color: #38a4f8 !important;
                    }

                    /* Border styles */
                    .border-warning {
                        border-color: #ffbe0b !important;
                    }

                    .border-danger {
                        border-color: #f1556c !important;
                    }

                    .border-left {
                        border-left: 1px solid #dee2e6 !important;
                    }

                    /* Button styles */
                    .btn-warning {
                        background-color: #ffbe0b;
                        border-color: #ffbe0b;
                        color: #fff;
                    }

                    .btn-warning:hover {
                        background-color: #e5aa0a;
                        border-color: #e5aa0a;
                        color: #fff;
                    }

                    .btn-danger {
                        background-color: #f1556c;
                        border-color: #f1556c;
                        color: #fff;
                    }

                    .btn-danger:hover {
                        background-color: #e03e56;
                        border-color: #e03e56;
                        color: #fff;
                    }

                    /* Avatar styles */
                    .avatar-title.rounded-circle {
                        border-radius: 50% !important;
                    }

                    /* Padding and margin utilities */
                    .px-3 {
                        padding-left: 1rem !important;
                        padding-right: 1rem !important;
                    }

                    .py-2 {
                        padding-top: 0.5rem !important;
                        padding-bottom: 0.5rem !important;
                    }

                    /* Background colors */
                    .bg-soft-warning {
                        background-color: rgba(255, 190, 11, 0.2) !important;
                    }

                    .bg-soft-danger {
                        background-color: rgba(241, 85, 108, 0.2) !important;
                    }

                    /* Equal height cards */
                    .row.equal-height {
                        display: flex;
                        flex-wrap: wrap;
                    }

                    .row.equal-height > [class*='col-'] {
                        display: flex;
                        flex-direction: column;
                    }

                    .row.equal-height .card {
                        flex: 1;
                        display: flex;
                        flex-direction: column;
                    }

                    .row.equal-height .card .card-body {
                        flex: 1;
                        display: flex;
                        flex-direction: column;
                    }

                    .row.equal-height .card .card-body > .row {
                        flex: 0 0 auto;
                    }

                    .gradient-user-avatar {
                        position: relative;
                        display: inline-block;
                    }

                    .avatar-circle {
                        width: 60px;
                        height: 60px;
                        background-color: rgba(255, 255, 255, 0.2);
                        border-radius: 50%;
                        color: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 24px;
                        font-weight: 600;
                        border: 2px solid rgba(255, 255, 255, 0.3);
                    }

                    .status-dot {
                        position: absolute;
                        bottom: 0;
                        right: 0;
                        width: 12px;
                        height: 12px;
                        border-radius: 50%;
                        border: 2px solid #182848;
                    }

                    .status-dot.online {
                        background-color: #02c58d;
                    }

                    .gradient-welcome-message h4 {
                        font-weight: 600;
                        color: white;
                    }

                    .gradient-welcome-message span,
                    .gradient-welcome-message i {
                        color: rgba(255, 255, 255, 0.8);
                    }

                    .gradient-stat-card {
                        display: flex;
                        align-items: center;
                        padding: 10px;
                        border-radius: 8px;
                        background-color: rgba(255, 255, 255, 0.1);
                        transition: all 0.2s;
                        margin-bottom: 10px;
                    }

                    .gradient-stat-card:hover {
                        background-color: rgba(255, 255, 255, 0.15);
                        transform: translateY(-2px);
                    }

                    .gradient-stat-icon {
                        width: 40px;
                        height: 40px;
                        border-radius: 8px;
                        background-color: rgba(255, 255, 255, 0.2);
                        color: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 10px;
                    }

                    .gradient-stat-icon i {
                        font-size: 20px;
                    }

                    .gradient-stat-info h5 {
                        margin: 0;
                        font-weight: 600;
                        font-size: 16px;
                        color: white;
                    }

                    .gradient-stat-info p {
                        margin: 0;
                        font-size: 12px;
                        color: rgba(255, 255, 255, 0.7);
                    }



                    @media (max-width: 767.98px) {
                        .gradient-welcome-message {
                            text-align: center;
                            margin-top: 15px;
                        }
                    }
                </style>
                @endif

                <!-- Add custom CSS for both dashboard headers -->
                <style>
                    /* Admin Enterprise Dashboard Header Styles */
                    .enterprise-dashboard-header {
                        position: relative;
                        background: #1a2942;
                        color: #fff;
                        padding: 2rem 0;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                        margin-bottom: 2rem;
                    }

                    .header-overlay {
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: linear-gradient(135deg, rgba(32, 66, 105, 0.8) 0%, rgba(26, 41, 66, 0.9) 100%);
                        z-index: 1;
                    }

                    .enterprise-dashboard-header .container-fluid {
                        position: relative;
                        z-index: 2;
                    }

                    .dashboard-header-content {
                        padding-left: 1.5rem;
                    }

                    .dashboard-logo {
                        display: flex;
                        align-items: center;
                        margin-bottom: 1rem;
                        padding: 10px 0;
                        position: relative;
                    }

                    .logo-icon {
                        width: 48px;
                        height: 48px;
                        background: rgba(255, 255, 255, 0.1);
                        border-radius: 12px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 1rem;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        overflow: hidden;
                    }

                    /* Custom logo styling */
                    .custom-logo {
                        width: 110px;
                        height: 110px;
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 12px;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
                        padding: 5px;
                        margin-right: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        position: relative;
                        z-index: 5;
                        overflow: visible;
                    }

                    .logo-image {
                        width: 90%;
                        height: auto;
                        object-fit: contain;
                        display: block;
                        filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.25));
                        transform: scale(0.95);
                        transition: transform 0.3s ease;
                    }

                    .custom-logo:hover .logo-image {
                        transform: scale(1);
                    }

                    .logo-icon i {
                        font-size: 24px;
                        color: #4e9eff;
                    }

                    .logo-text {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        padding-top: 10px;
                        padding-left: 12px;
                        margin-left: 0;
                        position: relative;
                        z-index: 4;
                    }

                    .logo-text span {
                        font-size: 2.4rem;
                        font-weight: 700;
                        letter-spacing: 1.8px;
                        line-height: 1;
                        margin-bottom: 6px;
                        color: #fff;
                        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
                        display: block;
                        transform: translateY(-2px);
                    }

                    .logo-text small {
                        font-size: 0.95rem;
                        opacity: 0.9;
                        text-transform: uppercase;
                        letter-spacing: 3px;
                        color: rgba(255, 255, 255, 0.95);
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
                        display: block;
                        transform: translateX(2px);
                    }

                    .dashboard-heading {
                        font-size: 2.5rem;
                        font-weight: 300;
                        margin-bottom: 1.5rem;
                        margin-top: 0;
                        color: #fff;
                        position: relative;
                        display: inline-block;
                    }

                    .dashboard-heading:after {
                        content: '';
                        position: absolute;
                        bottom: -10px;
                        left: 0;
                        width: 80px;
                        height: 4px;
                        background: #4e9eff;
                        border-radius: 2px;
                    }

                    .dashboard-metrics {
                        display: flex;
                        margin-top: 2rem;
                    }

                    .metric {
                        display: flex;
                        align-items: center;
                        margin-right: 2.5rem;
                        background: rgba(255, 255, 255, 0.05);
                        padding: 0.75rem 1.25rem;
                        border-radius: 8px;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                    }

                    .metric-icon {
                        width: 40px;
                        height: 40px;
                        background: rgba(78, 158, 255, 0.2);
                        border-radius: 8px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 1rem;
                    }

                    .metric-icon i {
                        font-size: 20px;
                        color: #4e9eff;
                    }

                    .metric-data {
                        display: flex;
                        flex-direction: column;
                    }

                    .metric-value {
                        font-size: 1.25rem;
                        font-weight: 700;
                        line-height: 1;
                    }

                    .metric-label {
                        font-size: 0.75rem;
                        opacity: 0.7;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }

                    .dashboard-header-sidebar {
                        background: rgba(255, 255, 255, 0.03);
                        border-radius: 8px;
                        padding: 1.5rem;
                        border: 1px solid rgba(255, 255, 255, 0.05);
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                    }

                    .user-welcome {
                        display: flex;
                        align-items: center;
                        margin-bottom: 1.5rem;
                    }

                    .user-avatar {
                        position: relative;
                        width: 60px;
                        height: 60px;
                        background: rgba(255, 255, 255, 0.1);
                        border-radius: 15px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 1rem;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    }

                    .user-avatar i {
                        font-size: 36px;
                        color: #fff;
                    }

                    .status-indicator {
                        position: absolute;
                        bottom: -3px;
                        right: -3px;
                        width: 14px;
                        height: 14px;
                        background: #4CAF50;
                        border-radius: 50%;
                        border: 2px solid #1a2942;
                    }

                    .user-info h4 {
                        font-size: 1.1rem;
                        font-weight: 500;
                        margin-bottom: 0.25rem;
                    }

                    .user-info p {
                        font-size: 0.85rem;
                        opacity: 0.7;
                        margin: 0;
                    }

                    .dashboard-actions {
                        display: flex;
                        flex-direction: column;
                    }

                    .action-item {
                        display: flex;
                        align-items: center;
                        margin-bottom: 0.75rem;
                        padding: 0.75rem;
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 6px;
                    }

                    .action-item i {
                        font-size: 1.1rem;
                        margin-right: 0.75rem;
                        color: #4e9eff;
                    }

                    .action-item span {
                        font-size: 0.85rem;
                    }

                    /* Employee Simple Dashboard Header Styles */
                    .employee-dashboard-header {
                        background: #fff;
                        padding: 1.5rem 0;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                        margin-bottom: 2rem;
                    }

                    .welcome-message h2 {
                        font-size: 1.8rem;
                        font-weight: 500;
                        margin-bottom: 0.5rem;
                        color: #333;
                    }

                    .welcome-message p {
                        font-size: 0.9rem;
                        margin-bottom: 0;
                    }

                    .quick-actions {
                        display: flex;
                        justify-content: flex-end;
                        align-items: center;
                    }

                    .quick-actions .btn {
                        padding: 0.5rem 1rem;
                        font-weight: 500;
                    }

                    @media (max-width: 991.98px) {
                        .dashboard-header-content {
                            margin-bottom: 2rem;
                        }

                        .dashboard-metrics {
                            flex-wrap: wrap;
                        }

                        .metric {
                            margin-bottom: 1rem;
                        }

                        .welcome-message {
                            margin-bottom: 1rem;
                            text-align: center;
                        }

                        .quick-actions {
                            justify-content: center;
                        }
                    }
                </style>

                @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                <!-- ADMIN DASHBOARD CARDS -->
                <div class="row dashboard-stats-row">
                    <!-- USERS CARD - Enhanced with more details and visual elements -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary mini-stat text-white">
                            <div class="p-3 mini-stat-desc">
                                <div class="clearfix">
                                    <h6 class="text-uppercase mt-0 float-left text-white">
                                        <i class="mdi mdi-account-group mr-1"></i> Users
                                    </h6>
                                    <h4 class="mb-3 mt-0 float-right">{{ $userCount }}</h4>
                                </div>
                                <div>
                                    @if($percentChange > 0)
                                        <span class="badge badge-light text-info"> <i class="mdi mdi-arrow-up-bold"></i> +{{ $percentChange }}% </span>
                                    @elseif($percentChange < 0)
                                        <span class="badge badge-light text-danger"> <i class="mdi mdi-arrow-down-bold"></i> {{ $percentChange }}% </span>
                                    @else
                                        <span class="badge badge-light text-warning"> <i class="mdi mdi-minus"></i> 0% </span>
                                    @endif
                                    <span class="ml-2 text-white">Last 30 days</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="float-right">
                                    <a href="{{ route('users.index') }}" class="text-white"><i class="mdi mdi-account-multiple h5"></i></a>
                                </div>
                                <p class="font-14 m-0 text-white">
                                    @if($latestUser)
                                        <i class="mdi mdi-account-plus mr-1"></i> Latest: {{ $latestUser->name }}
                                        <small class="d-block text-white">{{ $latestUser->created_at->diffForHumans() }}</small>
                                    @else
                                        <i class="mdi mdi-account-plus mr-1"></i> No users yet
                                    @endif
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="font-12 text-white"><i class="mdi mdi-shield-account mr-1"></i> Admins: {{ $adminCount }}</span>
                                    <span class="font-12 text-white"><i class="mdi mdi-account mr-1"></i> Regular: {{ $userCount - $adminCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PRODUCTS CARD - Completely redesigned with inventory insights -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-info mini-stat text-white">
                            <div class="p-3 mini-stat-desc">
                                <div class="clearfix">
                                    <h6 class="text-uppercase mt-0 float-left text-white">
                                        <i class="mdi mdi-package-variant-closed mr-1"></i> Products
                                    </h6>
                                    <h4 class="mb-3 mt-0 float-right">{{ $productCount }}</h4>
                                </div>
                                <div>
                                    @if($productPercentChange > 0)
                                        <span class="badge badge-light text-info"> <i class="mdi mdi-arrow-up-bold"></i> +{{ $productPercentChange }}% </span>
                                    @elseif($productPercentChange < 0)
                                        <span class="badge badge-light text-danger"> <i class="mdi mdi-arrow-down-bold"></i> {{ $productPercentChange }}% </span>
                                    @else
                                        <span class="badge badge-light text-warning"> <i class="mdi mdi-minus"></i> 0% </span>
                                    @endif
                                    <span class="ml-2 text-white">Last 30 days</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="float-right">
                                    <a href="{{ route('products.index') }}" class="text-white"><i class="mdi mdi-view-grid h5"></i></a>
                                </div>
                                <p class="font-14 m-0 text-white">
                                    @if($latestProduct)
                                        <i class="mdi mdi-new-box mr-1"></i> Latest: {{ $latestProduct->name }}
                                        <small class="d-block text-white">
                                            @if($latestProduct && is_object($latestProduct->category) && isset($latestProduct->category->name))
                                                in {{ $latestProduct->category->name }}
                                            @endif
                                        </small>
                                    @else
                                        <i class="mdi mdi-new-box mr-1"></i> No products yet
                                    @endif
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="font-12 text-white"><i class="mdi mdi-alert-circle mr-1"></i> Low stock: {{ $lowStockCount }}</span>
                                    <span class="font-12 text-white"><i class="mdi mdi-close-circle mr-1"></i> Out of stock: {{ $outOfStockCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ORDERS CARD - Redesigned with order status insights -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-pink mini-stat text-white">
                            <div class="p-3 mini-stat-desc">
                                <div class="clearfix">
                                    <h6 class="text-uppercase mt-0 float-left text-white">
                                        <i class="mdi mdi-cart mr-1"></i> Orders
                                    </h6>
                                    <h4 class="mb-3 mt-0 float-right">{{ $orderCount }}</h4>
                                </div>
                                <div>
                                    @if($orderPercentChange > 0)
                                        <span class="badge badge-light text-info"> <i class="mdi mdi-arrow-up-bold"></i> +{{ $orderPercentChange }}% </span>
                                    @elseif($orderPercentChange < 0)
                                        <span class="badge badge-light text-danger"> <i class="mdi mdi-arrow-down-bold"></i> {{ $orderPercentChange }}% </span>
                                    @else
                                        <span class="badge badge-light text-warning"> <i class="mdi mdi-minus"></i> 0% </span>
                                    @endif
                                    <span class="ml-2 text-white">Last 30 days</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="float-right">
                                    <a href="{{ route('orders.index') }}" class="text-white"><i class="mdi mdi-clipboard-text h5"></i></a>
                                </div>
                                <p class="font-14 m-0 text-white">
                                    @if($latestOrder)
                                        <i class="mdi mdi-clock mr-1"></i> Latest: Order #{{ $latestOrder->id }}
                                        <small class="d-block text-white">
                                            by {{ $latestOrder && is_object($latestOrder->user) && isset($latestOrder->user->name) ? $latestOrder->user->name : 'Unknown' }}
                                        </small>
                                    @else
                                        <i class="mdi mdi-clock mr-1"></i> No orders yet
                                    @endif
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="font-12 text-white"><i class="mdi mdi-clock-alert mr-1"></i> Pending: {{ $pendingOrderCount }}</span>
                                    <span class="font-12 text-white"><i class="mdi mdi-check-circle mr-1"></i> Completed: {{ $completedOrderCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REVENUE CARD - Enhanced with financial insights -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success mini-stat text-white">
                            <div class="p-3 mini-stat-desc">
                                <div class="clearfix">
                                    <h6 class="text-uppercase mt-0 float-left text-white">
                                        <i class="mdi mdi-currency-usd mr-1"></i> Revenue
                                    </h6>
                                    <h4 class="mb-3 mt-0 float-right">${{ number_format($totalRevenue, 2) }}</h4>
                                </div>
                                <div>
                                    @if($revenuePercentChange > 0)
                                        <span class="badge badge-light text-info"> <i class="mdi mdi-arrow-up-bold"></i> +{{ $revenuePercentChange }}% </span>
                                    @elseif($revenuePercentChange < 0)
                                        <span class="badge badge-light text-danger"> <i class="mdi mdi-arrow-down-bold"></i> {{ $revenuePercentChange }}% </span>
                                    @else
                                        <span class="badge badge-light text-warning"> <i class="mdi mdi-minus"></i> 0% </span>
                                    @endif
                                    <span class="ml-2 text-white">Last 30 days</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="float-right">
                                    <a href="{{ route('orders.index') }}" class="text-white"><i class="mdi mdi-chart-line h5"></i></a>
                                </div>
                                <p class="font-14 m-0 text-white">
                                    <i class="mdi mdi-calendar-month mr-1"></i> This month: ${{ number_format($lastMonthRevenue, 2) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="font-12 text-white"><i class="mdi mdi-cart-outline mr-1"></i> Avg order: ${{ $orderCount > 0 ? number_format($totalRevenue / $orderCount, 2) : '0.00' }}</span>
                                    <span class="font-12 text-white"><i class="mdi mdi-calendar-check mr-1"></i> {{ $completedOrderCount }} completed</span>
                                </div>
                            </div>
                        </div>
                    </div>


                @else


                <!-- DASHBOARD STATS CARDS -->
                <div class="row">
                    <!-- PRODUCTS OVERVIEW CARD -->
                    <div class="col-md-6">
                        <div class="card employee-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="employee-card-icon bg-info">
                                        <i class="mdi mdi-package-variant"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="mb-0">Products</h5>
                                        <p class="text-muted mb-0">Available inventory</p>
                                    </div>
                                </div>

                                <div class="row text-center mt-3">
                                    <div class="col-6">
                                        <div class="border-right">
                                            <h3 class="mb-1">{{ $productCount }}</h3>
                                            <p class="text-muted mb-0">Total Products</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h3 class="mb-1">{{ $categoryCount }}</h3>
                                        <p class="text-muted mb-0">Categories</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('products.index') }}" class="btn btn-info btn-block">
                                        <i class="mdi mdi-eye mr-1"></i> Browse Catalog
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MY ORDERS SUMMARY CARD -->
                    <div class="col-md-6">
                        <div class="card employee-card">
                            <div class="card-body">
                                @php
                                    $userOrders = Auth::user()->orders;
                                    $userOrderCount = $userOrders->count();
                                    $userCompletedCount = $userOrders->where('status', 'completed')->count();
                                    $userPendingCount = $userOrders->where('status', 'pending')->count();
                                @endphp

                                <div class="d-flex align-items-center mb-3">
                                    <div class="employee-card-icon bg-success">
                                        <i class="mdi mdi-clipboard-text-outline"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="mb-0">My Orders</h5>
                                        <p class="text-muted mb-0">Order status</p>
                                    </div>
                                </div>

                                <div class="row text-center mt-3">
                                    <div class="col-4">
                                        <div class="border-right">
                                            <h3 class="mb-1">{{ $userOrderCount }}</h3>
                                            <p class="text-muted mb-0">Total</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border-right">
                                            <h3 class="mb-1">{{ $userPendingCount }}</h3>
                                            <p class="text-muted mb-0">Pending</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="mb-1">{{ $userCompletedCount }}</h3>
                                        <p class="text-muted mb-0">Completed</p>
                                    </div>
                                </div>

                                <div class="mt-4 d-flex">
                                    <a href="{{ route('orders.index') }}" class="btn btn-success flex-grow-1 mr-2">
                                        <i class="mdi mdi-eye mr-1"></i> View Orders
                                    </a>
                                    <a href="{{ url('/create-order') }}" class="btn btn-primary flex-grow-1">
                                        <i class="mdi mdi-cart-plus mr-1"></i> New Order
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- CSS for employee dashboard -->
                <style>
                    /* Card styling */
                    .employee-card {
                        border: none;
                        border-radius: 10px;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                        transition: transform 0.2s, box-shadow 0.2s;
                        margin-bottom: 24px;
                    }

                    .employee-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    }

                    /* Welcome card styling */
                    .employee-welcome-card {
                        border: none;
                        border-radius: 10px;
                        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
                        color: white;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                    }

                    .welcome-title {
                        font-size: 1.5rem;
                        font-weight: 600;
                        color: white;
                    }

                    .employee-welcome-card .text-muted {
                        color: rgba(255,255,255,0.7) !important;
                    }

                    /* Icon styling */
                    .employee-card-icon {
                        width: 50px;
                        height: 50px;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .employee-card-icon i {
                        font-size: 24px;
                        color: white;
                    }

                    /* Colors */
                    .bg-info {
                        background-color: #38a4f8;
                    }

                    .bg-success {
                        background-color: #02c58d;
                    }

                    /* Border */
                    .border-right {
                        border-right: 1px solid #eee;
                    }

                    /* Responsive */
                    @media (max-width: 767.98px) {
                        .d-flex.justify-content-between.align-items-center {
                            flex-direction: column;
                            align-items: flex-start !important;
                        }

                        .d-none.d-md-flex {
                            display: flex !important;
                            margin-top: 15px;
                            width: 100%;
                        }

                        .d-none.d-md-flex .btn {
                            flex: 1;
                        }

                        .order-stats {
                            margin-top: 20px;
                            width: 100%;
                            justify-content: space-around;
                        }
                    }
                </style>
                @endif

                </div>
                <!-- end row -->

                @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
                <!-- ADMIN DETAILED INSIGHTS SECTION -->
                <!-- ADDITIONAL INSIGHTS SECTION -->
                <div class="row equal-height">
                    <!-- INVENTORY INSIGHTS WITH CHARTS -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="header-title mb-0">
                                        <i class="mdi mdi-package-variant mr-2 text-primary"></i> Inventory Insights
                                    </h4>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('products.index') }}" class="dropdown-item">View All Products</a>
                                            <a href="{{ route('products.create') }}" class="dropdown-item">Add New Product</a>
                                            <a href="{{ route('categories.index') }}" class="dropdown-item">Manage Categories</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Distribution by Category Chart -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card mb-3 border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm mr-3">
                                                        <span class="avatar-title bg-soft-primary text-primary rounded">
                                                            <i class="mdi mdi-chart-pie font-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-16 mb-0">Products by Category</h5>
                                                    </div>
                                                </div>
                                                <div class="chart-container premium-chart">
                                                    <canvas id="categoryDistributionChart"></canvas>
                                                    <div class="chart-overlay"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="card mb-3 border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm mr-3">
                                                        <span class="avatar-title bg-soft-info text-info rounded">
                                                            <i class="mdi mdi-tag-multiple font-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-16 mb-0">Stock Status</h5>
                                                    </div>
                                                </div>
                                                <div class="chart-container premium-chart">
                                                    <canvas id="stockStatusChart"></canvas>
                                                    <div class="chart-overlay"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inventory Alerts -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="font-16 mb-0"><i class="mdi mdi-alert-circle-outline mr-1 text-warning"></i> Inventory Alerts</h5>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="alert-card mb-3 p-3 rounded bg-soft-warning border-left border-warning" style="border-left-width: 4px !important;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon mr-3">
                                                            <i class="mdi mdi-alert-circle-outline text-warning" style="font-size: 24px;"></i>
                                                        </div>
                                                        <div class="alert-content">
                                                            <h6 class="mb-1">Low Stock Items</h6>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="font-weight-bold text-dark" style="font-size: 20px;">{{ $lowStockCount }}</span>
                                                                @if($lowStockCount > 0)
                                                                <a href="{{ route('products.filter', ['status' => 'low']) }}" class="btn btn-sm btn-warning">View Items</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="alert-card mb-3 p-3 rounded bg-soft-danger border-left border-danger" style="border-left-width: 4px !important;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon mr-3">
                                                            <i class="mdi mdi-close-circle-outline text-danger" style="font-size: 24px;"></i>
                                                        </div>
                                                        <div class="alert-content">
                                                            <h6 class="mb-1">Out of Stock Items</h6>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="font-weight-bold text-dark" style="font-size: 20px;">{{ $outOfStockCount }}</span>
                                                                @if($outOfStockCount > 0)
                                                                <a href="{{ route('products.filter', ['status' => 'out']) }}" class="btn btn-sm btn-danger">View Items</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ORDER & REVENUE INSIGHTS WITH CHARTS -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="header-title mb-0">
                                        <i class="mdi mdi-chart-areaspline mr-2 text-primary"></i> Sales & Revenue
                                    </h4>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('orders.index') }}" class="dropdown-item">View All Orders</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card mb-3 border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm mr-3">
                                                        <span class="avatar-title bg-soft-success text-success rounded">
                                                            <i class="mdi mdi-cart-outline font-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-16 mb-0">Orders by Status</h5>
                                                    </div>
                                                </div>
                                                <div class="chart-container premium-chart">
                                                    <canvas id="orderStatusChart"></canvas>
                                                    <div class="chart-overlay"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="card mb-3 border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm mr-3">
                                                        <span class="avatar-title bg-soft-primary text-primary rounded">
                                                            <i class="mdi mdi-currency-usd font-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-16 mb-0">Revenue Trend</h5>
                                                    </div>
                                                </div>
                                                <div class="revenue-chart-container">
                                                    <div class="chart-labels">
                                                        <span class="revenue-label">Revenue ($)</span>
                                                        <span class="orders-label">Orders</span>
                                                    </div>
                                                    <div class="chart-container premium-chart">
                                                        <canvas id="revenueTrendChart"></canvas>
                                                        <div class="chart-overlay"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- RECENT ORDERS SECTION -->
                                <div class="mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="font-weight-bold mb-0">
                                            <i class="mdi mdi-clipboard-text-outline mr-2 text-info"></i> Recent Orders
                                        </h5>
                                    </div>

                                    @if($latestOrder)
                                    <div class="recent-orders-table">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Order</th>
                                                    <th class="border-top-0">User</th>
                                                    <th class="border-top-0">Date</th>
                                                    <th class="border-top-0">Amount</th>
                                                    <th class="border-top-0">Status</th>
                                                    <th class="border-top-0 text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    // Get 3 most recent orders
                                                    $recentOrders = App\Models\Order::with('user')->latest()->take(3)->get();
                                                @endphp

                                                @foreach($recentOrders as $order)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="order-icon bg-soft-primary text-primary">
                                                                <i class="mdi mdi-package-variant"></i>
                                                            </div>
                                                            <div class="ml-2">
                                                                <span class="font-weight-medium">#{{ $order->id }}</span>
                                                                <small class="d-block text-muted">{{ $order->items->count() }} items</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span>{{ $order->user ? $order->user->name : 'Unknown' }}</span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td class="font-weight-medium">${{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        @if($order->status == 'completed')
                                                            <span class="badge badge-soft-success px-2 py-1">Completed</span>
                                                        @elseif($order->status == 'pending')
                                                            <span class="badge badge-soft-warning px-2 py-1">Pending</span>
                                                        @elseif($order->status == 'processing')
                                                            <span class="badge badge-soft-info px-2 py-1">Processing</span>
                                                        @else
                                                            <span class="badge badge-soft-secondary px-2 py-1">{{ ucfirst($order->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Add custom styling for the recent orders table -->
                                    <style>
                                        .recent-orders-table {
                                            border-radius: 8px;
                                            overflow: hidden;
                                            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                                        }

                                        .recent-orders-table .table {
                                            margin-bottom: 0;
                                        }

                                        .recent-orders-table thead th {
                                            background-color: #f8f9fa;
                                            font-weight: 600;
                                            color: #495057;
                                            font-size: 13px;
                                            padding: 12px 15px;
                                            border-bottom: 1px solid #eef2f7;
                                        }

                                        .recent-orders-table tbody td {
                                            padding: 12px 15px;
                                            vertical-align: middle;
                                            border-top: none;
                                            border-bottom: 1px solid #f1f3fa;
                                        }

                                        .recent-orders-table tbody tr:last-child td {
                                            border-bottom: none;
                                        }

                                        .recent-orders-table tbody tr:hover {
                                            background-color: #f8f9fa;
                                        }

                                        .order-icon {
                                            width: 36px;
                                            height: 36px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 6px;
                                        }

                                        .badge-soft-success {
                                            background-color: rgba(2, 197, 141, 0.15);
                                            color: #02c58d;
                                        }

                                        .badge-soft-warning {
                                            background-color: rgba(255, 190, 11, 0.15);
                                            color: #ffbe0b;
                                        }

                                        .badge-soft-info {
                                            background-color: rgba(56, 164, 248, 0.15);
                                            color: #38a4f8;
                                        }

                                        .badge-soft-secondary {
                                            background-color: rgba(108, 117, 125, 0.15);
                                            color: #6c757d;
                                        }
                                    </style>
                                    @else
                                    <div class="text-center py-4 bg-light rounded">
                                        <div class="mb-3">
                                            <i class="mdi mdi-cart-outline text-muted" style="font-size: 32px;"></i>
                                        </div>
                                        <h6 class="mb-1">No Orders Yet</h6>
                                        <p class="text-muted small mb-0">There are no recent orders to display</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- RECENT ORDERS SECTION -->
                <div class="row">
                    <div class="col-12">
                        <div class="card employee-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-history mr-2"></i> Recent Orders
                                    </h5>
                                    <a href="{{ url('/create-order') }}" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-plus mr-1"></i> New Order
                                    </a>
                                </div>

                                @php
                                    if (Auth::check() && is_object(Auth::user()) && is_object(Auth::user()->orders())) {
                                        $userLatestOrders = Auth::user()->orders()->latest()->take(5)->get();
                                    } else {
                                        $userLatestOrders = collect();
                                    }
                                @endphp

                                @if($userLatestOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover custom-table">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($userLatestOrders as $order)
                                            <tr>
                                                <td>
                                                    <span class="font-weight-medium">#{{ $order->id }}</span>
                                                </td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="font-weight-medium">${{ number_format($order->total_amount, 2) }}</span>
                                                </td>
                                                <td>
                                                    @if($order->status == 'completed')
                                                        <span class="badge badge-soft-success">Completed</span>
                                                    @elseif($order->status == 'pending')
                                                        <span class="badge badge-soft-warning">Pending</span>
                                                    @else
                                                        <span class="badge badge-soft-info">{{ ucfirst($order->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="mdi mdi-dots-horizontal font-18"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="{{ route('orders.show', $order) }}" class="dropdown-item">
                                                                <i class="mdi mdi-eye mr-1"></i> View Details
                                                            </a>
                                                            <a href="{{ route('orders.edit', $order) }}" class="dropdown-item">
                                                                <i class="mdi mdi-pencil mr-1"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger">
                                                                <i class="mdi mdi-delete mr-1"></i> Cancel
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center mt-4">
                                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                                            View All Orders <i class="mdi mdi-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-5 my-4">
                                    <div class="mb-4">
                                        <img src="{{ asset('admin/assets/images/empty-orders.svg') }}" alt="No Orders" class="img-fluid" style="max-width: 150px;">
                                    </div>
                                    <h4>No Orders Yet</h4>
                                    <p class="text-muted mb-4">You haven't placed any orders yet. Create your first order to get started.</p>
                                    <a href="{{ url('/create-order') }}" class="btn btn-primary">
                                        <i class="mdi mdi-cart-plus mr-1"></i> Create Your First Order
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PRODUCT CATALOG PREVIEW -->
                <div class="row">
                    <div class="col-12">
                        <div class="card employee-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-package-variant mr-2"></i> Popular Products
                                    </h5>
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">
                                        View All <i class="mdi mdi-arrow-right ml-1"></i>
                                    </a>
                                </div>

                                @php
                                    $popularProducts = App\Models\Product::inRandomOrder()->take(4)->get();
                                @endphp

                                <div class="row">
                                    @foreach($popularProducts as $product)
                                    <div class="col-md-3 col-sm-6">
                                        <div class="product-card">
                                            <div class="product-image">
                                                @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                                @else
                                                <div class="no-image">
                                                    <i class="mdi mdi-image-outline"></i>
                                                </div>
                                                @endif
                                                <div class="product-overlay">
                                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-light">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h6 class="product-title">{{ $product->name }}</h6>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                                    <span class="product-stock {{ $product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                                        {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional CSS for enhanced employee dashboard -->
                <style>
                    /* Table styling */
                    .custom-table {
                        border-collapse: separate;
                        border-spacing: 0 8px;
                    }

                    .custom-table thead th {
                        border-bottom: none;
                        background-color: #f8f9fa;
                        color: #495057;
                        font-weight: 600;
                        padding: 12px 15px;
                    }

                    .custom-table tbody tr {
                        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                        border-radius: 5px;
                        background-color: #fff;
                        transition: transform 0.15s;
                    }

                    .custom-table tbody tr:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 3px 5px rgba(0,0,0,0.1);
                    }

                    .custom-table tbody td {
                        padding: 15px;
                        vertical-align: middle;
                        border-top: none;
                    }

                    /* Badge styling */
                    .badge-soft-success {
                        background-color: rgba(2, 197, 141, 0.15);
                        color: #02c58d;
                        font-weight: 500;
                        padding: 5px 10px;
                    }

                    .badge-soft-warning {
                        background-color: rgba(255, 190, 11, 0.15);
                        color: #ffbe0b;
                        font-weight: 500;
                        padding: 5px 10px;
                    }

                    .badge-soft-info {
                        background-color: rgba(56, 164, 248, 0.15);
                        color: #38a4f8;
                        font-weight: 500;
                        padding: 5px 10px;
                    }

                    /* Dropdown styling */
                    .card-drop {
                        color: #98a6ad;
                        font-size: 20px;
                    }

                    .dropdown-toggle::after {
                        display: none;
                    }

                    .dropdown-menu {
                        box-shadow: 0 0 35px 0 rgba(154,161,171,.15);
                        border: none;
                    }

                    .dropdown-item {
                        padding: 8px 15px;
                    }

                    /* Product card styling */
                    .product-card {
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                        margin-bottom: 20px;
                        transition: transform 0.2s, box-shadow 0.2s;
                    }

                    .product-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    }

                    .product-image {
                        height: 160px;
                        position: relative;
                        overflow: hidden;
                        background-color: #f8f9fa;
                    }

                    .product-image img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }

                    .no-image {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        height: 100%;
                        color: #adb5bd;
                    }

                    .no-image i {
                        font-size: 48px;
                    }

                    .product-overlay {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0,0,0,0.2);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        opacity: 0;
                        transition: opacity 0.2s;
                    }

                    .product-card:hover .product-overlay {
                        opacity: 1;
                    }

                    .product-info {
                        padding: 15px;
                    }

                    .product-title {
                        margin-bottom: 10px;
                        font-weight: 500;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }

                    .product-price {
                        font-weight: 600;
                        color: #495057;
                    }

                    .product-stock {
                        font-size: 12px;
                        font-weight: 500;
                    }

                    .in-stock {
                        color: #02c58d;
                    }

                    .out-of-stock {
                        color: #f1556c;
                    }
                </style>
                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        @include('footer-dash')

        <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/waves.js')}}"></script>
        <script src="{{asset('admin/assets/js/jquery.slimscroll.js')}}"></script>

        <!-- Chart.js and ChartJS plugins -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

        <!--Morris Chart-->
        <script src="{{asset('plugins/morris/morris.min.js')}}"></script>
        <script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>

        <!-- dashboard js -->
        <script src="{{asset('admin/assets/pages/dashboard.int.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>

        @if(Auth::check() && is_object(Auth::user()) && Auth::user()->isAdmin())
        <!-- Clean Chart Styles -->
        <style>
            /* Chart Container */
            .chart-container {
                position: relative;
                height: 220px;
                margin: 0 auto;
                border-radius: 6px;
                overflow: hidden;
            }

            .premium-chart {
                background: #fff;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                padding: 10px;
                border: 1px solid rgba(0,0,0,0.05);
                transition: all 0.3s ease;
            }

            .premium-chart:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            }

            .chart-overlay {
                display: none; /* Simplified - removed overlay effect */
            }

            .chart-container canvas {
                transition: all 0.3s ease;
            }

            /* Revenue Chart Container and Labels */
            .revenue-chart-container {
                position: relative;
                margin-bottom: 15px;
            }

            .chart-labels {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
                padding: 0 15px;
            }

            .revenue-label, .orders-label {
                font-weight: bold;
                padding: 3px 10px;
                border-radius: 4px;
                font-size: 12px;
            }

            .revenue-label {
                color: white;
                background-color: rgba(75, 108, 183, 1);
            }

            .orders-label {
                color: white;
                background-color: rgba(2, 197, 141, 1);
            }

            /* Chart Legend */
            .chart-legend {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 10px;
            }

            .legend-item {
                display: flex;
                align-items: center;
                margin: 0 8px 5px 0;
                font-size: 12px;
                font-weight: 500;
            }

            .legend-color {
                width: 10px;
                height: 10px;
                border-radius: 2px;
                margin-right: 4px;
            }

            /* Chart Tooltip */
            .chart-tooltip {
                background: rgba(50, 50, 50, 0.8) !important;
                border-radius: 4px !important;
                padding: 8px 10px !important;
                color: white !important;
                font-weight: 500 !important;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
                border: none !important;
            }

            /* Card Header Enhancement - simplified */
            .card-body .avatar-sm {
                transition: all 0.2s ease;
            }

            .card:hover .avatar-sm {
                transform: scale(1.05);
            }

            /* Font Enhancement - simplified */
            .font-16 {
                font-weight: 500;
            }

            /* Removed chart title animation for simplicity */
        </style>

        <!-- Initialize Charts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Register Chart.js plugins
                Chart.register(ChartDataLabels);

                // Set simple tooltip styles
                Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(50, 50, 50, 0.8)';
                Chart.defaults.plugins.tooltip.titleColor = '#fff';
                Chart.defaults.plugins.tooltip.bodyColor = '#fff';
                Chart.defaults.plugins.tooltip.padding = 8;
                Chart.defaults.plugins.tooltip.cornerRadius = 4;
                Chart.defaults.plugins.tooltip.displayColors = true;

                // Common chart options - simplified
                const commonOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 800,
                        easing: 'easeOutQuad'
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: false
                    },
                    plugins: {
                        tooltip: {
                            enabled: true,
                            position: 'nearest',
                            displayColors: true,
                            usePointStyle: true
                        },
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                usePointStyle: true
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 11
                            },
                            textStrokeColor: 'rgba(0,0,0,0.2)',
                            textStrokeWidth: 2
                        }
                    }
                };

                // Professional color palette
                const colorPalette = {
                    primary: ['rgba(75, 108, 183, 0.8)', 'rgba(75, 108, 183, 1)'],
                    success: ['rgba(2, 197, 141, 0.8)', 'rgba(2, 197, 141, 1)'],
                    warning: ['rgba(255, 190, 11, 0.8)', 'rgba(255, 190, 11, 1)'],
                    danger: ['rgba(241, 85, 108, 0.8)', 'rgba(241, 85, 108, 1)'],
                    info: ['rgba(56, 164, 248, 0.8)', 'rgba(56, 164, 248, 1)'],
                    purple: ['rgba(111, 66, 193, 0.8)', 'rgba(111, 66, 193, 1)'],
                    teal: ['rgba(32, 201, 151, 0.8)', 'rgba(32, 201, 151, 1)'],
                    orange: ['rgba(253, 126, 20, 0.8)', 'rgba(253, 126, 20, 1)']
                };

                // Stock Status Chart
                const stockStatusCtx = document.getElementById('stockStatusChart').getContext('2d');
                const stockStatusData = [
                    {{ $productCount - $outOfStockCount - $lowStockCount }},
                    {{ $lowStockCount }},
                    {{ $outOfStockCount }}
                ];

                // Simple center text plugin for doughnut charts
                const centerTextPlugin = {
                    id: 'centerText',
                    beforeDraw: function(chart) {
                        if (chart.config.type === 'doughnut' || chart.config.type === 'pie') {
                            const ctx = chart.ctx;
                            const chartArea = chart.chartArea;
                            if (!chartArea) return;

                            const dataset = chart.data.datasets[0];
                            const total = dataset.data.reduce((a, b) => a + b, 0);

                            ctx.save();
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            const centerX = (chartArea.left + chartArea.right) / 2;
                            const centerY = (chartArea.top + chartArea.bottom) / 2;

                            ctx.font = 'bold 18px Arial, sans-serif';
                            ctx.fillStyle = '#333';
                            ctx.fillText(total, centerX, centerY);

                            ctx.restore();
                        }
                    }
                };

                // Register the plugin
                Chart.register(centerTextPlugin);

                // Simplified Stock Status Chart
                const stockStatusChart = new Chart(stockStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                        datasets: [{
                            data: stockStatusData,
                            backgroundColor: [
                                'rgba(2, 197, 141, 0.7)',
                                'rgba(255, 190, 11, 0.7)',
                                'rgba(241, 85, 108, 0.7)'
                            ],
                            borderColor: [
                                'rgba(2, 197, 141, 1)',
                                'rgba(255, 190, 11, 1)',
                                'rgba(241, 85, 108, 1)'
                            ],
                            borderWidth: 1,
                            hoverOffset: 5
                        }]
                    },
                    options: {
                        ...commonOptions,
                        cutout: '65%',
                        plugins: {
                            ...commonOptions.plugins,
                            datalabels: {
                                formatter: (value, ctx) => {
                                    if (value === 0) return '';
                                    const sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = (value * 100 / sum).toFixed(0) + '%';
                                    return percentage;
                                },
                                display: function(context) {
                                    const value = context.dataset.data[context.dataIndex];
                                    const sum = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = (value * 100 / sum);
                                    // Only show labels for segments that are at least 8% of the total
                                    return percentage >= 8;
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            centerText: {
                                enabled: true
                            }
                        }
                    }
                });

                // Category Distribution Chart
                @php
                    // Get top 5 categories with product counts
                    $topCategories = App\Models\Category::withCount('products')
                        ->orderBy('products_count', 'desc')
                        ->take(5)
                        ->get();

                    $categoryLabels = $topCategories->pluck('name')->toJson();
                    $categoryData = $topCategories->pluck('products_count')->toJson();
                @endphp

                // Simplified Category Distribution Chart
                const categoryDistributionCtx = document.getElementById('categoryDistributionChart').getContext('2d');

                const categoryDistributionChart = new Chart(categoryDistributionCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! $categoryLabels !!},
                        datasets: [{
                            label: 'Products',
                            data: {!! $categoryData !!},
                            backgroundColor: 'rgba(75, 108, 183, 0.7)',
                            borderColor: 'rgba(75, 108, 183, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                            maxBarThickness: 25
                        }]
                    },
                    options: {
                        ...commonOptions,
                        indexAxis: 'y',
                        plugins: {
                            ...commonOptions.plugins,
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Top Categories',
                                font: {
                                    size: 14,
                                    weight: 'normal'
                                },
                                padding: {
                                    bottom: 10
                                }
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'end',
                                formatter: (value) => value,
                                color: '#333',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Products: ${context.raw}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                }
                            },
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            }
                        }
                    }
                });

                // Order Status Chart
                const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
                const processingCount = {{ App\Models\Order::where('status', 'processing')->count() }};
                const cancelledCount = {{ App\Models\Order::where('status', 'cancelled')->count() }};

                // Simplified Order Status Chart
                const orderStatusChart = new Chart(orderStatusCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Completed', 'Pending', 'Processing', 'Cancelled'],
                        datasets: [{
                            data: [
                                {{ $completedOrderCount }},
                                {{ $pendingOrderCount }},
                                processingCount,
                                cancelledCount
                            ],
                            backgroundColor: [
                                'rgba(2, 197, 141, 0.7)',
                                'rgba(255, 190, 11, 0.7)',
                                'rgba(56, 164, 248, 0.7)',
                                'rgba(241, 85, 108, 0.7)'
                            ],
                            borderColor: [
                                'rgba(2, 197, 141, 1)',
                                'rgba(255, 190, 11, 1)',
                                'rgba(56, 164, 248, 1)',
                                'rgba(241, 85, 108, 1)'
                            ],
                            borderWidth: 1,
                            hoverOffset: 5
                        }]
                    },
                    options: {
                        ...commonOptions,
                        plugins: {
                            ...commonOptions.plugins,
                            datalabels: {
                                formatter: (value, ctx) => {
                                    if (value === 0) return '';
                                    const sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = (value * 100 / sum).toFixed(0) + '%';
                                    return percentage;
                                },
                                display: function(context) {
                                    const value = context.dataset.data[context.dataIndex];
                                    const sum = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = (value * 100 / sum);
                                    // Only show labels for segments that are at least 8% of the total
                                    return percentage >= 8;
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            centerText: {
                                enabled: true
                            }
                        }
                    }
                });

                // Revenue Trend Chart
                @php
                    // Get monthly revenue for the last 6 months
                    $months = [];
                    $monthlyRevenue = [];
                    $orderCounts = [];

                    for ($i = 5; $i >= 0; $i--) {
                        $month = now()->subMonths($i);
                        $months[] = $month->format('M Y');

                        $revenue = App\Models\Order::where('status', 'completed')
                            ->whereYear('created_at', $month->year)
                            ->whereMonth('created_at', $month->month)
                            ->sum('total_amount');

                        $count = App\Models\Order::whereYear('created_at', $month->year)
                            ->whereMonth('created_at', $month->month)
                            ->count();

                        $monthlyRevenue[] = $revenue;
                        $orderCounts[] = $count;
                    }
                @endphp

                // Simplified Revenue Trend Chart
                const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');

                // Debug the data to ensure it's properly formatted
                const monthLabels = {!! json_encode($months) !!};
                const revenueData = {!! json_encode($monthlyRevenue) !!};
                const orderData = {!! json_encode($orderCounts) !!};

                // Ensure data is numeric
                const numericRevenueData = revenueData.map(value => parseFloat(value) || 0);
                const numericOrderData = orderData.map(value => parseInt(value) || 0);

                // Log data for debugging
                console.log('Month Labels:', monthLabels);
                console.log('Revenue Data:', numericRevenueData);
                console.log('Order Data:', numericOrderData);

                // Create simple gradient for area fill
                const gradientFill = revenueTrendCtx.createLinearGradient(0, 0, 0, 220);
                gradientFill.addColorStop(0, 'rgba(75, 108, 183, 0.2)');
                gradientFill.addColorStop(1, 'rgba(75, 108, 183, 0.0)');

                const revenueTrendChart = new Chart(revenueTrendCtx, {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: [
                            {
                                label: 'Revenue',
                                data: numericRevenueData,
                                backgroundColor: gradientFill,
                                borderColor: 'rgba(75, 108, 183, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: 'rgba(75, 108, 183, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                order: 1,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Orders',
                                data: numericOrderData,
                                borderColor: 'rgba(2, 197, 141, 1)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                tension: 0.3,
                                fill: false,
                                pointBackgroundColor: 'rgba(2, 197, 141, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                order: 2,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        ...commonOptions,
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        plugins: {
                            ...commonOptions.plugins,
                            legend: {
                                display: true,
                                position: 'top',
                                align: 'end'
                            },
                            datalabels: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        let value = context.parsed.y || 0;

                                        if (label === 'Revenue') {
                                            return `${label}: $${value.toFixed(2)}`;
                                        } else {
                                            return `${label}: ${Math.round(value)}`;
                                        }
                                    },
                                    title: function(tooltipItems) {
                                        return tooltipItems[0].label;
                                    }
                                }
                            },
                            // Chart title - removed axis information text
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                position: 'left',
                                title: {
                                    display: false  // Hide the title since we're using the chart title
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value;
                                    },
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    padding: 8,
                                    color: 'rgba(75, 108, 183, 0.8)'
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                title: {
                                    display: false  // Hide the title since we're using the chart title
                                },
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    padding: 8,
                                    color: 'rgba(2, 197, 141, 0.8)'
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                // Simple hover effect for chart containers
                const chartContainers = document.querySelectorAll('.chart-container');
                chartContainers.forEach(container => {
                    container.addEventListener('mouseover', function() {
                        this.style.transform = 'translateY(-3px)';
                        this.style.transition = 'transform 0.3s ease';
                    });

                    container.addEventListener('mouseout', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });
            });
        </script>
        @endif

    </body>
</html>
