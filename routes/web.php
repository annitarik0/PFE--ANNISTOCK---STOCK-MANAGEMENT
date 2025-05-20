<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    // If the user is already authenticated, redirect to dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    // Otherwise, redirect to login page
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class])->name('dashboard');

Route::middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update-image');
});

require __DIR__.'/auth.php';

// Routes that require authentication
Route::middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class])->group(function () {
    // User management routes - admin only
    Route::middleware('admin')->group(function () {
        // Original user routes
        Route::resource("users", UserController::class)->except(['create', 'store']);

        // Special routes for user creation with our simplified controller
        Route::get('/users/create', [App\Http\Controllers\UserCreateController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\UserCreateController::class, 'store'])->name('users.store');

        Route::resource("categories", CategoryController::class);
    });

    // Product routes - split by permission level

    // Routes accessible to all authenticated users (view only)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Product filter routes - must be defined before the wildcard route
    Route::get('/products/filter/{status}', [ProductController::class, 'filterByStock'])->name('products.filter');

    // Admin-only product management routes
    Route::middleware('admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Product detail view - accessible to all authenticated users (must be after specific routes)
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Order routes - all authenticated users
    Route::resource("orders", OrderController::class)->except(['create', 'store']);

    // My Orders route - shows only the current user's orders
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');

    // Purchase Order PDF generation route
    Route::get('/orders/{order}/purchase-order', [OrderController::class, 'generatePurchaseOrder'])->name('orders.purchase-order');

    // Special routes for order creation with our simplified controller
    Route::get('/orders/create', [App\Http\Controllers\OrderCreateController::class, 'create'])->name('orders.create');
    Route::post('/orders', [App\Http\Controllers\OrderCreateController::class, 'store'])->name('orders.store');
});

Route::get('/clear-session', function() {
    Session::flush();
    return redirect()->back();
});

Route::post('/clear-flash-messages', function() {
    // Clear all flash messages
    session()->forget('success');
    session()->forget('error');
    session()->forget('warning');
    return response()->json(['status' => 'success']);
})->middleware('web');



// Direct route to create user page - protected by admin middleware
Route::get('/direct-create-user', function() {
    return view('users.create');
})->middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class, 'admin']);

// Order creation routes - using the original controller
Route::get('/create-order', [App\Http\Controllers\OrderCreateController::class, 'create'])
    ->middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class]);
Route::post('/store-order', [App\Http\Controllers\OrderCreateController::class, 'store'])
    ->middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class]);

// Add notification routes - all require authentication
Route::middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class])->group(function () {
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/count', [NotificationController::class, 'getUnreadCount'])->name('notifications.count');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
});

// Search routes
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/api/search', [SearchController::class, 'apiSearch'])->name('api.search');






