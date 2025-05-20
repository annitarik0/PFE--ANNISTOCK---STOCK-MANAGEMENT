<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Additional security check in the controller
        $this->middleware('auth');
        // Use the admin middleware alias
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Check if Auth::user() is a string instead of an object
        if (!is_object(auth()->user())) {
            // Log the error
            \Log::error('Auth::user() returned a non-object in ProductController', [
                'user' => auth()->user(),
                'type' => gettype(auth()->user())
            ]);

            // Force logout to clear the session
            auth()->logout();

            // Redirect to login page with error message
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please log in again.');
        }

        // If user is admin, show the admin product management view
        if (auth()->user()->isAdmin()) {
            $products = Product::with('category')->get();
            return view("products.index", compact("products"));
        }
        // Otherwise, show the employee catalog view
        else {
            $products = Product::with('category')->paginate(12);
            $categories = \App\Models\Category::all();
            return view("products.catalog", compact("products", "categories"));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Double-check that the user is an admin
        if (!auth()->user()->isAdmin()) {
            // Redirect to dashboard without error message
            return redirect()->route('dashboard');
        }

        $categories = Category::all();
        return view("products.create", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Double-check that the user is an admin
        if (!auth()->user()->isAdmin()) {
            // Redirect to dashboard without error message
            return redirect()->route('dashboard');
        }
        // Log the request data for debugging
        \Log::info('Product creation attempt - START', [
            'request_data' => $request->except(['image']),
            'has_image' => $request->hasFile('image'),
            'image_info' => $request->hasFile('image') ? [
                'name' => $request->file('image')->getClientOriginalName(),
                'size' => $request->file('image')->getSize(),
                'mime' => $request->file('image')->getMimeType(),
            ] : null,
            'session_id' => session()->getId(),
            'session_token' => csrf_token()
        ]);

        try {
            // Validate the request data
            \Log::info('Validating product data');

            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|unique:products',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                \Log::error('Product validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);

                return back()->withErrors($validator)->withInput();
            }

            \Log::info('Product validation passed');

            // Get the category name for the 'category' column
            $category = Category::find($request->category_id);
            if (!$category) {
                \Log::error('Category not found', [
                    'category_id' => $request->category_id
                ]);

                return back()->withErrors(['category_id' => 'Selected category does not exist.'])->withInput();
            }

            $productData = [
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                // Removed 'category' field as it doesn't exist in the database
                'description' => $request->description,
                // Removed 'min_stock' field as it doesn't exist in the database
            ];

            \Log::info('Product data prepared', [
                'product_data' => $productData
            ]);

            if ($request->hasFile('image')) {
                try {
                    \Log::info('Processing product image');

                    // Ensure the storage directory exists
                    if (!file_exists(public_path('storage/product_images'))) {
                        mkdir(public_path('storage/product_images'), 0755, true);
                    }

                    $path = $request->file('image')->store('product_images', 'public');
                    $productData['image'] = 'storage/' . $path;

                    \Log::info('Image stored successfully', [
                        'path' => $path,
                        'full_path' => 'storage/' . $path
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Image storage failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()])->withInput();
                }
            }

            \Log::info('Creating product with data', [
                'final_product_data' => $productData
            ]);

            $product = Product::create($productData);

            // Create notification for product creation
            try {
                \Log::info('Creating notification for new product');

                $notificationData = [
                    'message' => 'New product "' . $product->name . '" has been added to inventory with ' . $product->quantity . ' units',
                    'type' => 'success',
                    'is_read' => false,
                    'user_id' => auth()->id() ?? 1 // Add the user_id of the creator, default to 1 if not authenticated
                ];

                // Check if the title column exists in the notifications table
                if (Schema::hasColumn('notifications', 'title')) {
                    $notificationData['title'] = 'New Product Added';
                }

                \Log::info('Current authenticated user', [
                    'auth_id' => auth()->id(),
                    'auth_check' => auth()->check(),
                    'auth_user' => auth()->user() ? auth()->user()->toArray() : null
                ]);

                \Log::info('Notification data prepared', [
                    'notification_data' => $notificationData
                ]);

                $notification = Notification::create($notificationData);

                \Log::info('Notification created successfully', [
                    'notification_id' => $notification->id
                ]);
            } catch (\Exception $e) {
                \Log::error('Notification creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Don't throw the exception here, just log it
                // We still want to return success even if notification fails
            }

            \Log::info('Product creation completed successfully', [
                'product_id' => $product->id,
                'product_name' => $product->name
            ]);

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully');

        } catch (\Exception $e) {
            \Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Add a session flash message for better visibility
            session()->flash('error', 'Failed to create product: ' . $e->getMessage());

            return back()->withErrors(['general' => 'Failed to create product: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Double-check that the user is an admin
        if (!auth()->user()->isAdmin()) {
            // Redirect to dashboard without error message
            return redirect()->route('dashboard');
        }

        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Double-check that the user is an admin
        if (!auth()->user()->isAdmin()) {
            // Redirect to dashboard without error message
            return redirect()->route('dashboard');
        }

        $request->validate([
            'name' => 'required|string|unique:products,name,' . $id,
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            try {
                // Log the image upload attempt
                \Log::info('Processing product image update', [
                    'product_id' => $product->id,
                    'image_info' => [
                        'name' => $request->file('image')->getClientOriginalName(),
                        'size' => $request->file('image')->getSize(),
                        'mime' => $request->file('image')->getMimeType(),
                    ]
                ]);

                // Ensure the storage directory exists
                if (!file_exists(public_path('storage/product_images'))) {
                    mkdir(public_path('storage/product_images'), 0755, true);
                }

                // Delete old image if exists
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                    \Log::info('Deleted old product image', [
                        'old_image_path' => $product->image
                    ]);
                }

                // Store new image
                $path = $request->file('image')->store('product_images', 'public');
                $product->image = 'storage/' . $path;

                \Log::info('Image updated successfully', [
                    'new_path' => $path,
                    'full_path' => 'storage/' . $path
                ]);
            } catch (\Exception $e) {
                \Log::error('Image update failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()])->withInput();
            }
        }

        $product->save();

        // Create notification for product update
        try {
            $notificationData = [
                'message' => 'Product "' . $product->name . '" has been updated. New quantity: ' . $product->quantity . ', Price: $' . number_format($product->price, 2),
                'type' => 'warning',
                'is_read' => false,
                'user_id' => Auth::id() ?? 1 // Default to user ID 1 if not authenticated
            ];

            // Check if the title column exists in the notifications table
            if (Schema::hasColumn('notifications', 'title')) {
                $notificationData['title'] = 'Product Updated';
            }

            Notification::create($notificationData);

            \Log::info('Product update notification created successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to create product update notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Don't throw the exception, just log it
            // We still want to return success even if notification fails
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Double-check that the user is an admin
        if (!auth()->user()->isAdmin()) {
            // Redirect to dashboard without error message
            return redirect()->route('dashboard');
        }
        $product = Product::findOrFail($id);

        // Delete the product's image if it exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Store product information before deletion
        $productName = $product->name;
        $productPrice = $product->price;

        $product->delete();

        // Create notification for product deletion
        try {
            $userName = Auth::check() ? (is_object(Auth::user()) ? Auth::user()->name : 'Unknown User') : 'Unknown User';

            $notificationData = [
                'message' => 'Product "' . $productName . '" (Price: $' . number_format($productPrice, 2) . ') has been removed from inventory by ' . $userName,
                'type' => 'danger',
                'is_read' => false,
                'user_id' => Auth::id() ?? 1 // Default to user ID 1 if not authenticated
            ];

            // Check if the title column exists in the notifications table
            if (Schema::hasColumn('notifications', 'title')) {
                $notificationData['title'] = 'Product Deleted';
            }

            Notification::create($notificationData);

            \Log::info('Product deletion notification created successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to create product deletion notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Don't throw the exception, just log it
            // We still want to return success even if notification fails
        }

        return redirect()->route('products.index')
            ->with('warning', 'Product deleted successfully');
    }

    /**
     * Display a filtered list of products based on stock status.
     *
     * @param string $status - 'low' for low stock, 'out' for out of stock
     * @return \Illuminate\View\View
     */
    public function filterByStock($status)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Check if Auth::user() is a string instead of an object
        if (!is_object(auth()->user())) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please log in again.');
        }

        // Define the threshold for low stock (can be moved to config or settings)
        $lowStockThreshold = 10;

        // Filter products based on status
        if ($status === 'low') {
            $products = Product::with('category')
                ->where('quantity', '>', 0)
                ->where('quantity', '<=', $lowStockThreshold)
                ->get();
            $title = 'Low Stock Products';
            $filterType = 'low-stock';
        } elseif ($status === 'out') {
            $products = Product::with('category')
                ->where('quantity', '=', 0)
                ->get();
            $title = 'Out of Stock Products';
            $filterType = 'out-of-stock';
        } elseif ($status === 'all-alerts') {
            // Show both low stock and out of stock items
            $products = Product::with('category')
                ->where(function($query) use ($lowStockThreshold) {
                    $query->where('quantity', '=', 0)
                          ->orWhere(function($query) use ($lowStockThreshold) {
                              $query->where('quantity', '>', 0)
                                    ->where('quantity', '<=', $lowStockThreshold);
                          });
                })
                ->get();
            $title = 'Inventory Alerts';
            $filterType = 'all-alerts';
        } else {
            return redirect()->route('products.index');
        }

        // If user is admin, show the admin product management view with filter
        if (auth()->user()->isAdmin()) {
            return view("products.index", compact("products", "title", "filterType"));
        }
        // Otherwise, show the employee catalog view with filter
        else {
            $categories = \App\Models\Category::all();
            return view("products.catalog", compact("products", "categories", "title", "filterType"));
        }
    }
}




