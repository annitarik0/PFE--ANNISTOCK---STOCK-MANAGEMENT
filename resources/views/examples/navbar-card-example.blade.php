@extends('layouts.master')

@section('content')
    <!-- Example of using the navbar card component -->
    @component('components.navbar-card')
        @slot('icon', 'mdi-package-variant')
        @slot('title', 'Products Overview')
        @slot('count', $productCount ?? 0)
        @slot('subtitle', 'Current Inventory Status')
        @slot('badge', '+5%')
        @slot('badgeIcon', 'mdi-arrow-up-bold')
        @slot('badgeClass', 'text-info')
        @slot('linkUrl', route('products.index'))
        @slot('linkIcon', 'mdi-view-grid')
        @slot('footerLeft')
            <i class="mdi mdi-alert-circle mr-1"></i> Low stock: {{ $lowStockCount ?? 0 }}
        @endslot
        @slot('footerRight')
            <i class="mdi mdi-close-circle mr-1"></i> Out of stock: {{ $outOfStockCount ?? 0 }}
        @endslot

        <i class="mdi mdi-new-box mr-1"></i> Latest product added: {{ $latestProduct ?? 'None' }}
        <small class="d-block text-white">Click the grid icon to view all products</small>
    @endcomponent

    <!-- Example of a different color card -->
    @component('components.navbar-card')
        @slot('bgColor', 'bg-info')
        @slot('icon', 'mdi-cart')
        @slot('title', 'Orders Summary')
        @slot('count', $orderCount ?? 0)
        @slot('subtitle', 'Order Processing')
        @slot('badge', '+12%')
        @slot('badgeIcon', 'mdi-arrow-up-bold')
        @slot('badgeClass', 'text-info')
        @slot('linkUrl', route('orders.index'))
        @slot('linkIcon', 'mdi-clipboard-text')
        @slot('footerLeft')
            <i class="mdi mdi-clock-alert mr-1"></i> Pending: {{ $pendingOrderCount ?? 0 }}
        @endslot
        @slot('footerRight')
            <i class="mdi mdi-check-circle mr-1"></i> Completed: {{ $completedOrderCount ?? 0 }}
        @endslot

        <i class="mdi mdi-clock mr-1"></i> Latest order: Order #{{ $latestOrderId ?? '0' }}
        <small class="d-block text-white">Click the clipboard icon to view all orders</small>
    @endcomponent

    <!-- Example of a success color card -->
    @component('components.navbar-card')
        @slot('bgColor', 'bg-success')
        @slot('icon', 'mdi-currency-usd')
        @slot('title', 'Revenue')
        @slot('count', '$' . number_format($totalRevenue ?? 0, 2))
        @slot('subtitle', 'Financial Performance')
        @slot('badge', '+8%')
        @slot('badgeIcon', 'mdi-arrow-up-bold')
        @slot('badgeClass', 'text-info')
        @slot('linkUrl', route('orders.index'))
        @slot('linkIcon', 'mdi-chart-line')
        @slot('footerLeft')
            <i class="mdi mdi-calendar-month mr-1"></i> This month: ${{ number_format($monthlyRevenue ?? 0, 2) }}
        @endslot
        @slot('footerRight')
            <i class="mdi mdi-cart-outline mr-1"></i> Avg order: ${{ number_format($avgOrderValue ?? 0, 2) }}
        @endslot

        <i class="mdi mdi-trending-up mr-1"></i> Revenue is growing steadily
        <small class="d-block text-white">Click the chart icon to view detailed reports</small>
    @endcomponent
@endsection

@section('script')
<script>
    // Any additional JavaScript can go here
    $(document).ready(function() {
        console.log('Navbar card example loaded');
    });
</script>
@endsection
