<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Command to show system statistics
Artisan::command('app:stats', function () {
    $this->info('ANNISTOCK System Statistics');
    $this->info('-------------------------');
    $this->info('Users: ' . User::count());
    $this->info('Products: ' . Product::count());
    $this->info('Categories: ' . Category::count());
    $this->info('Orders: ' . Order::count());
    $this->info('Low Stock Products: ' . Product::whereRaw('quantity <= min_stock')->count());
    $this->info('Out of Stock Products: ' . Product::where('quantity', 0)->count());
    $this->info('Pending Orders: ' . Order::where('status', 'pending')->count());
    $this->info('Completed Orders: ' . Order::where('status', 'completed')->count());
})->purpose('Display system statistics');

// Command to reset admin password is now handled by ResetAdminPasswordCommand.php
