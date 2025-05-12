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
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        // Original user routes
        Route::resource("users", UserController::class)->except(['create', 'store']);

        // Special routes for user creation with our simplified controller
        Route::get('/users/create', [App\Http\Controllers\UserCreateController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\UserCreateController::class, 'store'])->name('users.store');

        Route::resource("categories", CategoryController::class);
    });

    // Product routes - all users can view
    Route::resource("products", ProductController::class);

    // Product filter routes
    Route::get('/products/filter/{status}', [ProductController::class, 'filterByStock'])->name('products.filter');

    // Order routes - all authenticated users
    Route::resource("orders", OrderController::class)->except(['create', 'store']);

    // My Orders route - shows only the current user's orders
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');

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

// Debug route for form submissions
Route::post('/debug-form', function(Illuminate\Http\Request $request) {
    \Log::info('Debug form submission', [
        'all_data' => $request->all(),
        'files' => $request->hasFile('image') ? 'Has image file' : 'No image file',
        'headers' => $request->headers->all(),
    ]);
    return response()->json(['status' => 'success', 'data' => $request->all()]);
});

// Direct route to create user page - protected by admin middleware
Route::get('/direct-create-user', function() {
    return view('users.create');
})->middleware(['auth', \App\Http\Middleware\HandleAuthErrors::class, \App\Http\Middleware\IsAdmin::class]);

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





