<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
        }

        // Check if Auth::user() is a string instead of an object
        if (!is_object(Auth::user())) {
            // Log the error
            \Log::error('Auth::user() returned a non-object in DashboardController', [
                'user' => Auth::user(),
                'type' => gettype(Auth::user())
            ]);

            // Force logout to clear the session
            Auth::logout();

            // Redirect to login page with error message
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please log in again.');
        }

        // Log that we've reached the dashboard
        \Log::info('Dashboard accessed', [
            'user_id' => $request->user() ? $request->user()->id : 'none',
            'user_email' => $request->user() ? $request->user()->email : 'none',
            'user_role' => $request->user() ? $request->user()->role : 'none'
        ]);
        // ===== USERS CARD =====
        // Get basic user count
        $userCount = User::count();

        // Get new users in the last 30 days
        $lastMonthCount = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Calculate percentage change
        $percentChange = 0;
        if ($userCount > 0) {
            $previousCount = $userCount - $lastMonthCount;
            if ($previousCount > 0) {
                $percentChange = round(($lastMonthCount / $previousCount) * 100);
            } else {
                $percentChange = 100; // If there were no users before, it's 100% growth
            }
        }

        // Get latest user
        $latestUser = User::latest()->first();

        // Check if role column exists before querying
        $adminCount = 0;
        if (Schema::hasColumn('users', 'role')) {
            $adminCount = User::where('role', 'admin')->count();
        }

        // ===== PRODUCTS CARD =====
        $productCount = Product::count();
        // Low stock should be > 0 and < 10, not including out of stock items
        $lowStockCount = Product::where('quantity', '>', 0)->where('quantity', '<', 10)->count();
        $outOfStockCount = Product::where('quantity', 0)->count();
        $latestProduct = Product::with('category')->latest()->first();

        // Calculate product percentage change
        $lastMonthProductCount = Product::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $productPercentChange = 0;
        if ($productCount > 0) {
            $previousProductCount = $productCount - $lastMonthProductCount;
            if ($previousProductCount > 0) {
                $productPercentChange = round(($lastMonthProductCount / $previousProductCount) * 100);
            } else {
                $productPercentChange = 100;
            }
        }

        // ===== ORDERS CARD =====
        $orderCount = Order::count();

        // Handle different status values based on database structure
        // Check if the status is enum with French values or varchar with English values
        $pendingOrderCount = Order::where(function($query) {
            $query->where('status', 'pending')
                  ->orWhere('status', 'en_attente');
        })->count();

        $completedOrderCount = Order::where(function($query) {
            $query->where('status', 'completed')
                  ->orWhere('status', 'valide');
        })->count();

        $latestOrder = Order::with('user')->latest()->first();

        // Calculate order percentage change
        $lastMonthOrderCount = Order::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $orderPercentChange = 0;
        if ($orderCount > 0) {
            $previousOrderCount = $orderCount - $lastMonthOrderCount;
            if ($previousOrderCount > 0) {
                $orderPercentChange = round(($lastMonthOrderCount / $previousOrderCount) * 100);
            } else {
                $orderPercentChange = 100;
            }
        }

        // Calculate total revenue
        $totalRevenue = Order::where(function($query) {
            $query->where('status', 'completed')
                  ->orWhere('status', 'valide');
        })->sum('total_amount');

        $lastMonthRevenue = Order::where(function($query) {
            $query->where('status', 'completed')
                  ->orWhere('status', 'valide');
        })
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->sum('total_amount');

        // Calculate revenue percentage change
        $revenuePercentChange = 0;
        if ($totalRevenue > 0) {
            $previousMonthRevenue = Order::where(function($query) {
                $query->where('status', 'completed')
                      ->orWhere('status', 'valide');
            })
            ->whereBetween('created_at', [Carbon::now()->subDays(60), Carbon::now()->subDays(30)])
            ->sum('total_amount');

            if ($previousMonthRevenue > 0) {
                $revenuePercentChange = round((($lastMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100);
            } elseif ($lastMonthRevenue > 0) {
                $revenuePercentChange = 100; // If there was no revenue before but there is now, it's 100% growth
            }
        }

        // ===== CATEGORIES CARD =====
        $categoryCount = Category::count();
        $topCategory = null;
        $topCategoryProductCount = 0;

        // Find the category with the most products
        if ($categoryCount > 0) {
            $topCategoryData = Category::withCount('products')
                ->orderBy('products_count', 'desc')
                ->first();

            if ($topCategoryData) {
                $topCategory = $topCategoryData;
                $topCategoryProductCount = $topCategoryData->products_count;
            }
        }

        // Calculate average products per category
        $avgProductsPerCategory = $categoryCount > 0 ? round($productCount / $categoryCount, 1) : 0;

        return view('dashboard', [
            // Users card data
            'userCount' => $userCount,
            'lastMonthCount' => $lastMonthCount,
            'percentChange' => $percentChange,
            'latestUser' => $latestUser,
            'adminCount' => $adminCount,

            // Products card data
            'productCount' => $productCount,
            'lowStockCount' => $lowStockCount,
            'outOfStockCount' => $outOfStockCount,
            'latestProduct' => $latestProduct,
            'productPercentChange' => $productPercentChange,

            // Orders card data
            'orderCount' => $orderCount,
            'pendingOrderCount' => $pendingOrderCount,
            'completedOrderCount' => $completedOrderCount,
            'latestOrder' => $latestOrder,
            'orderPercentChange' => $orderPercentChange,

            // Revenue card data
            'totalRevenue' => $totalRevenue,
            'lastMonthRevenue' => $lastMonthRevenue,
            'revenuePercentChange' => $revenuePercentChange,

            // Categories card data
            'categoryCount' => $categoryCount,
            'topCategory' => $topCategory,
            'topCategoryProductCount' => $topCategoryProductCount,
            'avgProductsPerCategory' => $avgProductsPerCategory
        ]);
    }
}

