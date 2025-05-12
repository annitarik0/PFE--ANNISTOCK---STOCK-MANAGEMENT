<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Handle the search request and display results page
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query) || strlen($query) < 2) {
            return redirect()->back()->with('error', 'Please enter at least 2 characters to search');
        }

        // Get search results
        $results = $this->getSearchResults($query);

        // Calculate total results based on user role
        $totalResults = count($results['products']) + count($results['orders']);

        // Add categories and users to total count only for admins
        if (Auth::check() && Auth::user()->isAdmin()) {
            $totalResults += count($results['categories']) + count($results['users']);
        }

        return view('search.results', [
            'query' => $query,
            'results' => $results,
            'totalResults' => $totalResults
        ]);
    }

    /**
     * API endpoint for live search results
     */
    public function apiSearch(Request $request)
    {
        try {
            $query = $request->input('query');

            if (empty($query) || strlen($query) < 2) {
                return response()->json(['results' => []]);
            }

            // Get all search results
            $searchResults = $this->getSearchResults($query);

            // Format results for API response
            $formattedResults = [];

            // Add products
            foreach ($searchResults['products'] as $product) {
                try {
                    $formattedResults[] = [
                        'type' => 'product',
                        'title' => $product->name,
                        'subtitle' => 'Product • ' . ($product->category ? $product->category->name : 'No Category') . ' • ' . $product->price,
                        'url' => route('products.show', $product->id)
                    ];
                } catch (\Exception $e) {
                    // Skip this product if there's an error
                    continue;
                }
            }

            // Add categories (admin only)
            if (Auth::check() && Auth::user()->isAdmin()) {
                foreach ($searchResults['categories'] as $category) {
                    try {
                        $formattedResults[] = [
                            'type' => 'category',
                            'title' => $category->name,
                            'subtitle' => 'Category • ' . (method_exists($category, 'products') ? $category->products->count() : '0') . ' products',
                            'url' => route('categories.show', $category->id)
                        ];
                    } catch (\Exception $e) {
                        // Skip this category if there's an error
                        continue;
                    }
                }
            }

            // Add orders
            foreach ($searchResults['orders'] as $order) {
                try {
                    $formattedResults[] = [
                        'type' => 'order',
                        'title' => 'Order #' . $order->id,
                        'subtitle' => 'Order • ' . $order->created_at->format('M d, Y') . ' • ' . $order->status,
                        'url' => route('orders.show', $order->id)
                    ];
                } catch (\Exception $e) {
                    // Skip this order if there's an error
                    continue;
                }
            }

            // Add users (admin only)
            if (Auth::check() && Auth::user()->isAdmin()) {
                foreach ($searchResults['users'] as $user) {
                    try {
                        $formattedResults[] = [
                            'type' => 'user',
                            'title' => $user->name,
                            'subtitle' => 'User • ' . $user->email,
                            'url' => route('users.show', $user->id)
                        ];
                    } catch (\Exception $e) {
                        // Skip this user if there's an error
                        continue;
                    }
                }
            }

            // Limit to 10 results for performance
            $formattedResults = array_slice($formattedResults, 0, 10);

            return response()->json(['results' => $formattedResults]);
        } catch (\Exception $e) {
            // If there's any error, return an empty result set
            return response()->json(['results' => [], 'error' => 'An error occurred while searching']);
        }
    }

    /**
     * Get search results from all relevant models
     */
    private function getSearchResults($query)
    {
        try {
            // Search products
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // If there's an error, return an empty collection
            $products = collect([]);
        }

        try {
            // Search categories
            $categories = Category::where('name', 'like', "%{$query}%")
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            // If there's an error, return an empty collection
            $categories = collect([]);
        }

        // Search orders
        try {
            if (Auth::check() && Auth::user()->isAdmin()) {
                // Admins can see all orders
                $orders = Order::where('id', 'like', "%{$query}%")
                    ->orWhere('status', 'like', "%{$query}%")
                    ->limit(3)
                    ->get();
            } else {
                // Regular users can only see their own orders
                $orders = Order::where('user_id', Auth::id())
                    ->where(function($q) use ($query) {
                        $q->where('id', 'like', "%{$query}%")
                            ->orWhere('status', 'like', "%{$query}%");
                    })
                    ->limit(3)
                    ->get();
            }
        } catch (\Exception $e) {
            // If there's an error, return an empty collection
            $orders = collect([]);
        }

        // Search users (admin only)
        try {
            if (Auth::check() && Auth::user()->isAdmin()) {
                $users = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->limit(3)
                    ->get();
            } else {
                $users = collect([]);
            }
        } catch (\Exception $e) {
            // If there's an error, return an empty collection
            $users = collect([]);
        }

        return [
            'products' => $products,
            'categories' => $categories,
            'orders' => $orders,
            'users' => $users
        ];
    }
}
