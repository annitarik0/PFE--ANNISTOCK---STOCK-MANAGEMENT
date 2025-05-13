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
     * Handle the search request and display results page with advanced filtering
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter', 'all'); // Default filter is 'all'
        $sort = $request->input('sort', 'relevance'); // Default sort is by relevance
        $perPage = $request->input('per_page', 12); // Default items per page

        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter at least 1 character to search');
        }

        // Debug log to check the search query
        \Log::info('Search query: ' . $query);

        // Get search results
        $results = $this->getSearchResults($query);

        // Debug log to check what results were found
        \Log::info('Search results - Products: ' . count($results['products']) .
                  ', Categories: ' . count($results['categories']) .
                  ', Orders: ' . count($results['orders']) .
                  ', Users: ' . (isset($results['users']) ? count($results['users']) : 0));

        // Apply filters based on user selection
        $filteredResults = $this->applyFilters($results, $filter);

        // Debug log to check filtered results
        \Log::info('Filtered results - Products: ' . count($filteredResults['products']) .
                  ', Categories: ' . count($filteredResults['categories']) .
                  ', Orders: ' . count($filteredResults['orders']) .
                  ', Users: ' . (isset($filteredResults['users']) ? count($filteredResults['users']) : 0));

        // Apply sorting based on user selection
        $sortedResults = $this->applySorting($filteredResults, $sort);

        // Calculate total results based on user role and filters
        $totalResults = count($sortedResults['products']) + count($sortedResults['orders']);

        // Add categories and users to total count only for admins
        if (Auth::check() && Auth::user()->isAdmin()) {
            $totalResults += count($sortedResults['categories']) + count($sortedResults['users']);
        }

        // Get search suggestions for related searches
        $suggestions = $this->getSearchSuggestions($query, $results);

        return view('search.results', [
            'query' => $query,
            'results' => $sortedResults,
            'totalResults' => $totalResults,
            'filter' => $filter,
            'sort' => $sort,
            'perPage' => $perPage,
            'suggestions' => $suggestions,
            'searchTerms' => $results['searchTerms'] ?? []
        ]);
    }

    /**
     * Apply filters to search results
     */
    private function applyFilters($results, $filter)
    {
        // If filter is 'all', return all results
        if ($filter === 'all') {
            return $results;
        }

        // Create a copy of results to modify
        $filteredResults = $results;

        // Apply specific filters
        switch ($filter) {
            case 'products':
                // Keep only products
                $filteredResults['categories'] = collect([]);
                $filteredResults['orders'] = collect([]);
                $filteredResults['users'] = collect([]);
                break;

            case 'categories':
                // Keep only categories
                $filteredResults['products'] = collect([]);
                $filteredResults['orders'] = collect([]);
                $filteredResults['users'] = collect([]);
                break;

            case 'orders':
                // Keep only orders
                $filteredResults['products'] = collect([]);
                $filteredResults['categories'] = collect([]);
                $filteredResults['users'] = collect([]);
                break;

            case 'users':
                // Keep only users (admin only)
                $filteredResults['products'] = collect([]);
                $filteredResults['categories'] = collect([]);
                $filteredResults['orders'] = collect([]);
                break;

            case 'in-stock':
                // Filter products to only show those in stock
                if (isset($filteredResults['products'])) {
                    $filteredResults['products'] = $filteredResults['products']->filter(function($product) {
                        return $product->quantity > 0;
                    });
                }
                break;

            case 'out-of-stock':
                // Filter products to only show those out of stock
                if (isset($filteredResults['products'])) {
                    $filteredResults['products'] = $filteredResults['products']->filter(function($product) {
                        return $product->quantity <= 0;
                    });
                }
                break;

            case 'completed-orders':
                // Filter orders to only show completed ones
                if (isset($filteredResults['orders'])) {
                    $filteredResults['orders'] = $filteredResults['orders']->filter(function($order) {
                        return $order->status === 'completed';
                    });
                }
                break;

            case 'pending-orders':
                // Filter orders to only show pending ones
                if (isset($filteredResults['orders'])) {
                    $filteredResults['orders'] = $filteredResults['orders']->filter(function($order) {
                        return $order->status === 'pending';
                    });
                }
                break;
        }

        return $filteredResults;
    }

    /**
     * Apply sorting to search results
     */
    private function applySorting($results, $sort)
    {
        // Create a copy of results to modify
        $sortedResults = $results;
        $query = $results['query'] ?? '';

        // Default sorting by relevance (prioritize "starts with" matches)
        if ($sort === 'relevance' && !empty($query)) {
            // Sort products by relevance
            if (isset($sortedResults['products']) && $sortedResults['products']->count() > 0) {
                $sortedResults['products'] = $sortedResults['products']->sortBy(function($product) use ($query) {
                    // Highest priority: name starts with query (case insensitive)
                    if (stripos($product->name, $query) === 0) {
                        return 0;
                    }
                    // Second priority: name contains query
                    else if (stripos($product->name, $query) !== false) {
                        return 1;
                    }
                    // Third priority: description contains query
                    else if (stripos($product->description, $query) !== false) {
                        return 2;
                    }
                    // Lowest priority: other matches
                    else {
                        return 3;
                    }
                });
            }

            // Sort categories by relevance
            if (isset($sortedResults['categories']) && $sortedResults['categories']->count() > 0) {
                $sortedResults['categories'] = $sortedResults['categories']->sortBy(function($category) use ($query) {
                    // Highest priority: name starts with query (case insensitive)
                    if (stripos($category->name, $query) === 0) {
                        return 0;
                    }
                    // Second priority: name contains query
                    else if (stripos($category->name, $query) !== false) {
                        return 1;
                    }
                    // Third priority: description contains query
                    else if (isset($category->description) && stripos($category->description, $query) !== false) {
                        return 2;
                    }
                    // Lowest priority: other matches
                    else {
                        return 3;
                    }
                });
            }

            // Sort users by relevance
            if (isset($sortedResults['users']) && $sortedResults['users']->count() > 0) {
                $sortedResults['users'] = $sortedResults['users']->sortBy(function($user) use ($query) {
                    // Highest priority: name starts with query (case insensitive)
                    if (stripos($user->name, $query) === 0) {
                        return 0;
                    }
                    // Second priority: name contains query
                    else if (stripos($user->name, $query) !== false) {
                        return 1;
                    }
                    // Third priority: email contains query
                    else if (stripos($user->email, $query) !== false) {
                        return 2;
                    }
                    // Lowest priority: other matches
                    else {
                        return 3;
                    }
                });
            }
        }
        // Apply other specific sorting options
        else {
            switch ($sort) {
                case 'name_asc':
                    // Sort products by name (A-Z)
                    if (isset($sortedResults['products']) && $sortedResults['products']->count() > 0) {
                        $sortedResults['products'] = $sortedResults['products']->sortBy('name');
                    }

                    // Sort categories by name (A-Z)
                    if (isset($sortedResults['categories']) && $sortedResults['categories']->count() > 0) {
                        $sortedResults['categories'] = $sortedResults['categories']->sortBy('name');
                    }

                    // Sort users by name (A-Z)
                    if (isset($sortedResults['users']) && $sortedResults['users']->count() > 0) {
                        $sortedResults['users'] = $sortedResults['users']->sortBy('name');
                    }
                    break;

                case 'name_desc':
                    // Sort products by name (Z-A)
                    if (isset($sortedResults['products']) && $sortedResults['products']->count() > 0) {
                        $sortedResults['products'] = $sortedResults['products']->sortByDesc('name');
                    }

                    // Sort categories by name (Z-A)
                    if (isset($sortedResults['categories']) && $sortedResults['categories']->count() > 0) {
                        $sortedResults['categories'] = $sortedResults['categories']->sortByDesc('name');
                    }

                    // Sort users by name (Z-A)
                    if (isset($sortedResults['users']) && $sortedResults['users']->count() > 0) {
                        $sortedResults['users'] = $sortedResults['users']->sortByDesc('name');
                    }
                    break;

                case 'price_asc':
                    // Sort products by price (low to high)
                    if (isset($sortedResults['products']) && $sortedResults['products']->count() > 0) {
                        $sortedResults['products'] = $sortedResults['products']->sortBy('price');
                    }
                    break;

                case 'price_desc':
                    // Sort products by price (high to low)
                    if (isset($sortedResults['products']) && $sortedResults['products']->count() > 0) {
                        $sortedResults['products'] = $sortedResults['products']->sortByDesc('price');
                    }
                    break;

                case 'date_asc':
                    // Sort orders by date (oldest first)
                    if (isset($sortedResults['orders']) && $sortedResults['orders']->count() > 0) {
                        $sortedResults['orders'] = $sortedResults['orders']->sortBy('created_at');
                    }
                    break;

                case 'date_desc':
                    // Sort orders by date (newest first)
                    if (isset($sortedResults['orders']) && $sortedResults['orders']->count() > 0) {
                        $sortedResults['orders'] = $sortedResults['orders']->sortByDesc('created_at');
                    }
                    break;

                case 'quantity_asc':
                    // Sort products by quantity (low to high)
                    if (isset($sortedResults['products']) && $sortedResults['products']->count() > 0) {
                        $sortedResults['products'] = $sortedResults['products']->sortBy('quantity');
                    }
                    break;

                case 'quantity_desc':
                    // Sort products by quantity (high to low)
                    if (isset($sortedResults['products']) && $sortedResults['products']->count() > 0) {
                        $sortedResults['products'] = $sortedResults['products']->sortByDesc('quantity');
                    }
                    break;
            }
        }

        return $sortedResults;
    }

    /**
     * Generate search suggestions based on search query and results
     */
    private function getSearchSuggestions($query, $results)
    {
        $suggestions = [];
        $searchTerms = $results['searchTerms'] ?? [];

        // If we have search terms, generate suggestions based on them
        if (count($searchTerms) > 0) {
            // Suggest searching for each individual term
            foreach ($searchTerms as $term) {
                if (strlen($term) >= 3 && $term !== $query) {
                    $suggestions[] = $term;
                }
            }

            // Suggest category-specific searches if we have product results
            if (isset($results['products']) && $results['products']->count() > 0) {
                $categories = $results['products']->pluck('category.name')->filter()->unique()->take(3);
                foreach ($categories as $category) {
                    $suggestions[] = $query . ' in ' . $category;
                }
            }
        }

        // Add some common modifiers as suggestions
        if (isset($results['products']) && $results['products']->count() > 0) {
            $suggestions[] = $query . ' in stock';
            $suggestions[] = $query . ' out of stock';
        }

        // Limit to 5 unique suggestions
        return array_slice(array_unique($suggestions), 0, 5);
    }

    /**
     * API endpoint for live search results with enhanced capabilities
     */
    public function apiSearch(Request $request)
    {
        try {
            $query = $request->input('query');
            $filter = $request->input('filter', 'all');
            $limit = $request->input('limit', 10);

            if (empty($query)) {
                return response()->json([
                    'results' => [],
                    'suggestions' => []
                ]);
            }

            // Get all search results with enhanced search
            $searchResults = $this->getSearchResults($query);

            // Apply filters if specified
            if ($filter !== 'all') {
                $searchResults = $this->applyFilters($searchResults, $filter);
            }

            // Format results for API response
            $formattedResults = [];
            $resultCount = 0;
            $maxResultsPerType = ceil($limit / 4); // Distribute results evenly

            // Add products with enhanced details
            foreach ($searchResults['products'] as $product) {
                if (count($formattedResults) >= $limit) break;

                try {
                    // Determine stock status for badge
                    $stockStatus = '';
                    $stockClass = '';

                    if ($product->quantity <= 0) {
                        $stockStatus = 'Out of Stock';
                        $stockClass = 'danger';
                    } elseif ($product->quantity <= 5) {
                        $stockStatus = 'Low Stock';
                        $stockClass = 'warning';
                    } else {
                        $stockStatus = 'In Stock';
                        $stockClass = 'success';
                    }

                    // Format price with currency
                    $formattedPrice = '$' . number_format($product->price, 2);

                    $formattedResults[] = [
                        'type' => 'product',
                        'id' => $product->id,
                        'title' => $product->name,
                        'subtitle' => 'Product • ' . ($product->category ? $product->category->name : 'No Category') . ' • ' . $formattedPrice,
                        'url' => route('products.show', $product->id),
                        'image' => $product->image ? asset($product->image) : asset('admin/assets/images/product-placeholder.jpg'),
                        'badge' => [
                            'text' => $stockStatus,
                            'class' => $stockClass
                        ],
                        'details' => [
                            'price' => $formattedPrice,
                            'quantity' => $product->quantity,
                            'category' => $product->category ? $product->category->name : 'No Category'
                        ]
                    ];

                    $resultCount++;
                    if ($resultCount >= $maxResultsPerType && $filter === 'all') break;

                } catch (\Exception $e) {
                    // Skip this product if there's an error
                    \Log::error('Error formatting product search result: ' . $e->getMessage());
                    continue;
                }
            }

            // Add categories (admin only) with enhanced details
            if (Auth::check() && Auth::user()->isAdmin()) {
                $resultCount = 0;
                foreach ($searchResults['categories'] as $category) {
                    if (count($formattedResults) >= $limit) break;

                    try {
                        $productCount = method_exists($category, 'products') ? $category->products->count() : 0;

                        $formattedResults[] = [
                            'type' => 'category',
                            'id' => $category->id,
                            'title' => $category->name,
                            'subtitle' => 'Category • ' . $productCount . ' products',
                            'url' => route('categories.show', $category->id),
                            'image' => asset('admin/assets/images/category-placeholder.jpg'),
                            'badge' => [
                                'text' => $productCount > 0 ? 'Active' : 'Empty',
                                'class' => $productCount > 0 ? 'success' : 'warning'
                            ],
                            'details' => [
                                'productCount' => $productCount,
                                'description' => Str::limit($category->description ?? 'No description', 50)
                            ]
                        ];

                        $resultCount++;
                        if ($resultCount >= $maxResultsPerType && $filter === 'all') break;

                    } catch (\Exception $e) {
                        // Skip this category if there's an error
                        \Log::error('Error formatting category search result: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            // Add orders with enhanced details
            $resultCount = 0;
            foreach ($searchResults['orders'] as $order) {
                if (count($formattedResults) >= $limit) break;

                try {
                    // Determine status for badge
                    $statusClass = '';
                    switch ($order->status) {
                        case 'completed':
                            $statusClass = 'success';
                            break;
                        case 'pending':
                            $statusClass = 'warning';
                            break;
                        case 'cancelled':
                            $statusClass = 'danger';
                            break;
                        default:
                            $statusClass = 'info';
                    }

                    // Format total with currency
                    $formattedTotal = '$' . number_format($order->total, 2);

                    $formattedResults[] = [
                        'type' => 'order',
                        'id' => $order->id,
                        'title' => 'Order #' . $order->id,
                        'subtitle' => 'Order • ' . $order->created_at->format('M d, Y') . ' • ' . ucfirst($order->status),
                        'url' => route('orders.show', $order->id),
                        'image' => asset('admin/assets/images/order-placeholder.jpg'),
                        'badge' => [
                            'text' => ucfirst($order->status),
                            'class' => $statusClass
                        ],
                        'details' => [
                            'date' => $order->created_at->format('M d, Y'),
                            'total' => $formattedTotal,
                            'items' => $order->items ? $order->items->count() : 0
                        ]
                    ];

                    $resultCount++;
                    if ($resultCount >= $maxResultsPerType && $filter === 'all') break;

                } catch (\Exception $e) {
                    // Skip this order if there's an error
                    \Log::error('Error formatting order search result: ' . $e->getMessage());
                    continue;
                }
            }

            // Add users (admin only) with enhanced details
            if (Auth::check() && Auth::user()->isAdmin()) {
                $resultCount = 0;
                foreach ($searchResults['users'] as $user) {
                    if (count($formattedResults) >= $limit) break;

                    try {
                        $formattedResults[] = [
                            'type' => 'user',
                            'id' => $user->id,
                            'title' => $user->name,
                            'subtitle' => 'User • ' . $user->email,
                            'url' => route('users.show', $user->id),
                            'image' => $user->image ? asset($user->image) : asset('admin/assets/images/user-placeholder.jpg'),
                            'badge' => [
                                'text' => $user->isAdmin() ? 'Admin' : 'Employee',
                                'class' => $user->isAdmin() ? 'primary' : 'secondary'
                            ],
                            'details' => [
                                'email' => $user->email,
                                'joined' => $user->created_at->format('M d, Y'),
                                'orders' => method_exists($user, 'orders') ? $user->orders->count() : 0
                            ]
                        ];

                        $resultCount++;
                        if ($resultCount >= $maxResultsPerType && $filter === 'all') break;

                    } catch (\Exception $e) {
                        // Skip this user if there's an error
                        \Log::error('Error formatting user search result: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            // Get search suggestions
            $suggestions = $this->getSearchSuggestions($query, $searchResults);

            // Return formatted results with suggestions
            return response()->json([
                'results' => $formattedResults,
                'suggestions' => $suggestions,
                'query' => $query,
                'filter' => $filter,
                'totalResults' => count($formattedResults)
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Search API error: ' . $e->getMessage());

            // Return an empty result set instead of an error
            // This will show "No results found" instead of "An error occurred"
            return response()->json([
                'results' => [],
                'suggestions' => [],
                'error' => 'No results found'
            ]);
        }
    }

    /**
     * Get search results from all relevant models with enhanced search capabilities
     */
    private function getSearchResults($query)
    {
        // Clean and prepare the search query
        $cleanQuery = trim($query);
        $searchTerms = preg_split('/\s+/', $cleanQuery, -1, PREG_SPLIT_NO_EMPTY);

        // Debug log the search terms
        \Log::info('Search terms: ' . implode(', ', $searchTerms));

        try {
            // Enhanced product search with relevance scoring
            $productQuery = Product::query();

            // Search in multiple fields with different weights
            $productQuery->where(function($q) use ($cleanQuery, $searchTerms) {
                // Starts with match on name (highest priority)
                $q->where('name', 'like', $cleanQuery . '%')
                  ->orWhere('sku', 'like', $cleanQuery . '%');

                // Contains match on name (high priority)
                $q->orWhere('name', 'like', '%' . $cleanQuery . '%');

                // Match on individual terms in name and description
                foreach ($searchTerms as $term) {
                    if (strlen($term) >= 1) { // Allow single character searches
                        // Prioritize "starts with" matches
                        $q->orWhere('name', 'like', $term . '%')
                          ->orWhere('description', 'like', $term . '%');

                        // Then include "contains" matches
                        $q->orWhere('name', 'like', '%' . $term . '%')
                          ->orWhere('description', 'like', '%' . $term . '%');
                    }
                }

                // Search by price if the query looks like a number
                if (is_numeric($cleanQuery)) {
                    $q->orWhere('price', $cleanQuery)
                      ->orWhere('price', 'like', $cleanQuery . '%');
                }

                // Search by quantity if the query looks like a number
                if (is_numeric($cleanQuery)) {
                    $q->orWhere('quantity', $cleanQuery);
                }
            });

            // Debug the SQL query
            $productSql = $productQuery->toSql();
            $productBindings = $productQuery->getBindings();
            \Log::info('Product search SQL: ' . $productSql);
            \Log::info('Product search bindings: ' . implode(', ', $productBindings));

            // Get products with pagination for full search page
            $products = $productQuery->orderBy('name')->limit(12)->get();

            // Log the found products
            \Log::info('Found products: ' . $products->pluck('name')->implode(', '));

        } catch (\Exception $e) {
            \Log::error('Product search error: ' . $e->getMessage());
            \Log::error('Product search error trace: ' . $e->getTraceAsString());
            $products = collect([]);
        }

        try {
            // Enhanced category search
            $categoryQuery = Category::query();

            $categoryQuery->where(function($q) use ($cleanQuery, $searchTerms) {
                // Starts with match on name (highest priority)
                $q->where('name', 'like', $cleanQuery . '%');

                // Contains match on name (high priority)
                $q->orWhere('name', 'like', '%' . $cleanQuery . '%');

                // Match on description
                $q->orWhere('description', 'like', '%' . $cleanQuery . '%');

                // Match on individual terms
                foreach ($searchTerms as $term) {
                    if (strlen($term) >= 1) { // Allow single character searches
                        // Prioritize "starts with" matches
                        $q->orWhere('name', 'like', $term . '%')
                          ->orWhere('description', 'like', $term . '%');

                        // Then include "contains" matches
                        $q->orWhere('name', 'like', '%' . $term . '%')
                          ->orWhere('description', 'like', '%' . $term . '%');
                    }
                }
            });

            // Debug the SQL query
            $categorySql = $categoryQuery->toSql();
            $categoryBindings = $categoryQuery->getBindings();
            \Log::info('Category search SQL: ' . $categorySql);
            \Log::info('Category search bindings: ' . implode(', ', $categoryBindings));

            $categories = $categoryQuery->orderBy('name')->limit(6)->get();

            // Log the found categories
            \Log::info('Found categories: ' . $categories->pluck('name')->implode(', '));

        } catch (\Exception $e) {
            \Log::error('Category search error: ' . $e->getMessage());
            \Log::error('Category search error trace: ' . $e->getTraceAsString());
            $categories = collect([]);
        }

        // Enhanced order search
        try {
            $orderQuery = Order::query();

            if (Auth::check() && Auth::user()->isAdmin()) {
                // Admins can see all orders with enhanced search
                $orderQuery->where(function($q) use ($cleanQuery, $searchTerms) {
                    // Search by order ID - starts with
                    $q->where('id', 'like', $cleanQuery . '%');

                    // Search by order ID - contains
                    $q->orWhere('id', 'like', '%' . $cleanQuery . '%');

                    // Search by status - starts with
                    $q->orWhere('status', 'like', $cleanQuery . '%');

                    // Search by status - contains
                    $q->orWhere('status', 'like', '%' . $cleanQuery . '%');

                    // Search by total if query is numeric
                    if (is_numeric($cleanQuery)) {
                        $q->orWhere('total', $cleanQuery)
                          ->orWhere('total', 'like', $cleanQuery . '%');
                    }

                    // Search by date if query looks like a date
                    if (preg_match('/^\d{2,4}[-\/]\d{1,2}[-\/]\d{1,2}$/', $cleanQuery) ||
                        preg_match('/^\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}$/', $cleanQuery)) {
                        $q->orWhereDate('created_at', 'like', '%' . $cleanQuery . '%');
                    }

                    // Search by month name
                    $months = ['january', 'february', 'march', 'april', 'may', 'june',
                              'july', 'august', 'september', 'october', 'november', 'december'];
                    $lowercaseQuery = strtolower($cleanQuery);
                    foreach ($months as $index => $month) {
                        if (strpos($month, $lowercaseQuery) !== false) {
                            $monthNumber = $index + 1;
                            $q->orWhereMonth('created_at', $monthNumber);
                        }
                    }
                });
            } else {
                // Regular users can only see their own orders with enhanced search
                $orderQuery->where('user_id', Auth::id())
                    ->where(function($q) use ($cleanQuery, $searchTerms) {
                        // Search by order ID - starts with
                        $q->where('id', 'like', $cleanQuery . '%');

                        // Search by order ID - contains
                        $q->orWhere('id', 'like', '%' . $cleanQuery . '%');

                        // Search by status - starts with
                        $q->orWhere('status', 'like', $cleanQuery . '%');

                        // Search by status - contains
                        $q->orWhere('status', 'like', '%' . $cleanQuery . '%');

                        // Search by total if query is numeric
                        if (is_numeric($cleanQuery)) {
                            $q->orWhere('total', $cleanQuery)
                              ->orWhere('total', 'like', $cleanQuery . '%');
                        }

                        // Search by date if query looks like a date
                        if (preg_match('/^\d{2,4}[-\/]\d{1,2}[-\/]\d{1,2}$/', $cleanQuery) ||
                            preg_match('/^\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}$/', $cleanQuery)) {
                            $q->orWhereDate('created_at', 'like', '%' . $cleanQuery . '%');
                        }
                    });
            }

            $orders = $orderQuery->orderBy('created_at', 'desc')->limit(8)->get();

        } catch (\Exception $e) {
            \Log::error('Order search error: ' . $e->getMessage());
            $orders = collect([]);
        }

        // Enhanced user search (admin only)
        try {
            if (Auth::check() && Auth::user()->isAdmin()) {
                $userQuery = User::query();

                $userQuery->where(function($q) use ($cleanQuery, $searchTerms) {
                    // Search by name - starts with
                    $q->where('name', 'like', $cleanQuery . '%');

                    // Search by name - contains
                    $q->orWhere('name', 'like', '%' . $cleanQuery . '%');

                    // Search by email - starts with
                    $q->orWhere('email', 'like', $cleanQuery . '%');

                    // Search by email - contains
                    $q->orWhere('email', 'like', '%' . $cleanQuery . '%');

                    // Search by individual terms
                    foreach ($searchTerms as $term) {
                        if (strlen($term) >= 1) { // Allow single character searches
                            // Prioritize "starts with" matches
                            $q->orWhere('name', 'like', $term . '%')
                              ->orWhere('email', 'like', $term . '%');

                            // Then include "contains" matches
                            $q->orWhere('name', 'like', '%' . $term . '%')
                              ->orWhere('email', 'like', '%' . $term . '%');
                        }
                    }
                });

                $users = $userQuery->orderBy('name')->limit(6)->get();
            } else {
                $users = collect([]);
            }
        } catch (\Exception $e) {
            \Log::error('User search error: ' . $e->getMessage());
            $users = collect([]);
        }

        return [
            'products' => $products,
            'categories' => $categories,
            'orders' => $orders,
            'users' => $users,
            'query' => $cleanQuery,
            'searchTerms' => $searchTerms
        ];
    }
}
