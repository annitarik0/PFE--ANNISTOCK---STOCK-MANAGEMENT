<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    // No middleware needed here as it's handled in routes

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all orders for both admin and regular employees
        // All employees should be able to see all orders for inventory management
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(10);

        return view('orders.pro-index', compact('orders'));
    }

    /**
     * Display a listing of the current user's orders.
     */
    public function myOrders()
    {
        // Get only the orders created by the current user
        $orders = Order::with(['user', 'items.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        // Use the same view as index but with a different title and description
        return view('orders.pro-index', [
            'orders' => $orders,
            'isMyOrders' => true,
            'title' => 'My Orders',
            'description' => 'View and manage your personal orders'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all products for the order form
        $products = Product::where('quantity', '>', 0)->with('category')->get();

        return view('orders.pro-create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log the request data for debugging
        \Log::info('Order creation request received', [
            'request_data' => $request->all()
        ]);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
            'name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            \Log::error('Order validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create a new order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->name = $request->name; // Save the custom name if provided
            $order->status = 'pending';
            $order->notes = $request->notes;
            $order->total_amount = 0; // Will be calculated later
            $order->save();

            $totalAmount = 0;

            // Add order items
            foreach ($request->product_ids as $index => $productId) {
                $product = Product::findOrFail($productId);
                $quantity = $request->quantities[$index];

                // Check if there's enough stock
                if ($product->quantity < $quantity) {
                    throw new \Exception("Not enough stock for {$product->name}. Available: {$product->quantity}");
                }

                // Create order item
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->quantity = $quantity;
                $orderItem->price = $product->price;
                $orderItem->save();

                // Update product quantity
                $product->quantity -= $quantity;
                $product->save();

                // Add to total amount
                $totalAmount += ($product->price * $quantity);
            }

            // Update order total
            $order->total_amount = $totalAmount;
            $order->save();

            // Commit the transaction
            DB::commit();

            // Create notification for order creation
            $userName = Auth::check() ? (is_object(Auth::user()) ? Auth::user()->name : 'Unknown User') : 'Unknown User';

            try {
                \Log::info('Creating notification for new order', [
                    'order_id' => $order->id,
                    'user_name' => $userName,
                    'total_amount' => $totalAmount
                ]);

                $notificationData = [
                    'title' => 'New Order Created',
                    'message' => 'New order "' . $order->getDisplayName() . '" has been created by ' . $userName . ' for $' . number_format($totalAmount, 2),
                    'type' => 'success',
                    'is_read' => false,
                    'user_id' => Auth::id() ?? 1 // Default to user ID 1 if not authenticated
                ];

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

            return redirect()->route('orders.index')
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error for debugging
            \Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // All employees should be able to view any order details
        // for inventory management purposes

        // Load the order with its items and products
        $order->load(['user', 'items.product']);

        return view('orders.pro-show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Enhanced logging for debugging
        \Log::info('Order update request received - DETAILED LOG', [
            'order_id' => $order->id,
            'current_status' => $order->status,
            'request_data' => $request->all(),
            'request_method' => $request->method(),
            'is_ajax' => $request->ajax(),
            'user_id' => Auth::id(),
            'user_role' => Auth::user() ? Auth::user()->role : 'unknown'
        ]);

        // Check if user is authorized to update this order
        // Admins can update any order, employees can only update their own orders
        $isAdmin = Auth::user()->isAdmin();
        $isOrderCreator = Auth::id() === $order->user_id;

        if (!$isAdmin && !$isOrderCreator) {
            \Log::warning('Unauthorized order update attempt', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role,
                'order_id' => $order->id,
                'order_user_id' => $order->user_id
            ]);

            if ($request->ajax()) {
                return response()->json(['error' => 'You are not authorized to update this order.'], 403);
            }

            return redirect()->route('orders.index')
                ->with('error', 'You can only update orders that you created.');
        }

        \Log::info('Authorized order status update attempt', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role,
            'order_id' => $order->id,
            'is_admin' => $isAdmin,
            'is_order_creator' => $isOrderCreator
        ]);

        // Validate the request with enhanced logging
        \Log::info('Validating order update request', [
            'order_id' => $order->id,
            'validation_rules' => [
                'status' => 'required|in:pending,processing,completed,cancelled',
                'name' => 'nullable|string|max:255',
                'notes' => 'nullable|string|max:500',
            ],
            'request_data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,completed,cancelled',
            'name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            \Log::warning('Order update validation failed - DETAILED LOG', [
                'order_id' => $order->id,
                'errors' => $validator->errors()->toArray(),
                'request_data' => $request->all(),
                'validation_rules' => $validator->getRules()
            ]);

            if ($request->ajax()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            \Log::info('Updating order status', [
                'order_id' => $order->id,
                'old_status' => $order->status,
                'new_status' => $request->status
            ]);

            // If cancelling an order, restore product quantities
            if ($request->status === 'cancelled' && $order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->quantity += $item->quantity;
                    $product->save();

                    \Log::info('Restored product quantity due to order cancellation', [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'restored_quantity' => $item->quantity,
                        'new_product_quantity' => $product->quantity
                    ]);
                }
            }

            // Update the order with enhanced logging
            $oldStatus = $order->status;

            \Log::info('Updating order - BEFORE CHANGES', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'request_status' => $request->status
            ]);

            // Set the new status
            $order->status = $request->status;

            // Check if the name column exists in the orders table
            $columns = \DB::connection()->getSchemaBuilder()->getColumnListing('orders');
            $nameColumnExists = in_array('name', $columns);

            \Log::info('Name column check', [
                'name_column_exists' => $nameColumnExists,
                'columns' => $columns
            ]);

            // Update the order name if provided and if the column exists
            if ($request->has('name') && $nameColumnExists) {
                $order->name = $request->name;
            }

            // Only update notes if they are provided
            if ($request->has('notes')) {
                $order->notes = $request->notes;
            }

            // Save the order and check if it was successful
            $saveResult = $order->save();

            \Log::info('Order update result - DETAILED LOG', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $order->status,
                'save_result' => $saveResult,
                'order_after_save' => $order->toArray(),
                'name_column_exists' => $nameColumnExists
            ]);

            // Commit the transaction with enhanced logging
            try {
                DB::commit();
                \Log::info('Transaction committed successfully for order update', [
                    'order_id' => $order->id,
                    'new_status' => $order->status
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to commit transaction for order update', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e; // Re-throw to be caught by the outer try-catch
            }

            // Check if a notification for this order update already exists within the last minute
            $recentNotification = Notification::where('message', 'LIKE', '%has been updated to status%')
                ->where('message', 'LIKE', '%' . $order->id . '%')
                ->where('created_at', '>=', now()->subMinute())
                ->first();

            \Log::info('Checking for recent notifications', [
                'order_id' => $order->id,
                'recent_notification_exists' => (bool)$recentNotification,
                'recent_notification_id' => $recentNotification ? $recentNotification->id : null
            ]);

            if (!$recentNotification) {
                try {
                    // Create notification for order update only if one doesn't already exist
                    $notification = Notification::create([
                        'title' => 'Order Status Updated',
                        'message' => 'Order "' . $order->getDisplayName() . '" has been updated to status: ' . ucfirst($order->status),
                        'type' => 'warning',
                        'is_read' => false,
                        'user_id' => Auth::id() ?? 1 // Default to user ID 1 if not authenticated
                    ]);

                    \Log::info('Order update notification created successfully', [
                        'notification_id' => $notification->id,
                        'order_id' => $order->id,
                        'notification_data' => $notification->toArray()
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create notification for order update', [
                        'order_id' => $order->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    // Don't throw this exception, just log it
                }
            } else {
                \Log::info('Skipped creating duplicate notification for order update', [
                    'order_id' => $order->id,
                    'existing_notification_id' => $recentNotification->id
                ]);
            }

            // Handle AJAX requests differently
            if ($request->ajax()) {
                // Log the successful AJAX response for debugging
                \Log::info('Sending AJAX success response', [
                    'order_id' => $order->id,
                    'order_name' => $order->name,
                    'order_status' => $order->status,
                    'display_name' => $order->getDisplayName()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Order updated successfully',
                    'order' => [
                        'id' => $order->id,
                        'name' => $order->name,
                        'status' => $order->status,
                        'display_name' => $order->getDisplayName()
                    ]
                ]);
            }

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error with enhanced logging
            try {
                DB::rollBack();
                \Log::info('Transaction rolled back successfully after error', [
                    'order_id' => $order->id
                ]);
            } catch (\Exception $rollbackException) {
                \Log::error('Failed to rollback transaction after error', [
                    'order_id' => $order->id,
                    'rollback_error' => $rollbackException->getMessage(),
                    'rollback_trace' => $rollbackException->getTraceAsString(),
                    'original_error' => $e->getMessage()
                ]);
            }

            \Log::error('Order update failed - DETAILED ERROR LOG', [
                'order_id' => $order->id,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            if ($request->ajax()) {
                // Log the AJAX error response for debugging
                \Log::error('Sending AJAX error response', [
                    'order_id' => $order->id,
                    'error_message' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine()
                ]);

                return response()->json(['error' => $e->getMessage()], 500);
            }

            // Add a flash message for better user feedback
            \Session::flash('error', 'Failed to update order: ' . $e->getMessage());

            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Generate a PDF purchase order for an order with 'processing' status.
     */
    public function generatePurchaseOrder(Order $order)
    {
        try {
            // Security check: Only admins or the user who created the order can generate purchase orders
            if (!Auth::user()->isAdmin() && Auth::id() !== $order->user_id) {
                \Log::warning('Unauthorized attempt to generate purchase order', [
                    'order_id' => $order->id,
                    'order_user_id' => $order->user_id,
                    'current_user_id' => Auth::id(),
                    'is_admin' => Auth::user()->isAdmin()
                ]);
                return redirect()->back()->with('error', 'You are not authorized to generate purchase orders for this order.');
            }

            // Check if order status allows purchase order generation
            if ($order->status !== 'completed') {
                return redirect()->back()->with('error', 'Purchase orders can only be generated for completed orders.');
            }

            // Load order with relationships
            $order->load(['user', 'items.product']);

            // Check if GD extension is loaded
            if (!extension_loaded('gd')) {
                \Log::warning('GD extension not loaded. Using text-only PDF template.');
                // We'll continue anyway, as we've modified the template to not require images
            }

            // Log for debugging
            \Log::info('Generating purchase order PDF', [
                'order_id' => $order->id,
                'order_status' => $order->status,
                'user_id' => $order->user_id,
                'current_user_id' => Auth::id(),
                'is_admin' => Auth::user()->isAdmin(),
                'items_count' => $order->items->count(),
                'gd_extension_loaded' => extension_loaded('gd'),
                'allowed_status' => 'completed'
            ]);

            // Configure PDF options for better rendering
            $options = [
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'helvetica',
                'dpi' => 150,
                'defaultPaperSize' => 'a4',
                'defaultPaperOrientation' => 'portrait',
                'isFontSubsettingEnabled' => true,
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 5,
                'margin_bottom' => 5
            ];

            // Prepare data for the PDF view
            $data = [
                'order' => $order,
                'company' => [
                    'name' => 'ANNISTOCK Inc.',
                    'tagline' => 'Inventory Management',
                    'address' => 'Enterprise Analytics',
                    'email' => 'support@annistock.com'
                ],
                'generated_at' => now()->format('F d, Y H:i:s')
            ];

            // Generate PDF with options
            $pdf = PDF::loadView('orders.pdf.purchase-order', $data)
                      ->setOptions($options);

            // Return the PDF for download
            return $pdf->download('purchase-order-' . $order->id . '.pdf');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to generate purchase order PDF', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'gd_extension_loaded' => extension_loaded('gd')
            ]);

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to generate purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Only admins can delete orders
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('orders.index')
                ->with('error', 'You are not authorized to delete orders.');
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // If the order is not cancelled, restore product quantities
            if ($order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->quantity += $item->quantity;
                    $product->save();
                }
            }

            // Store order information before deletion
            $orderId = $order->id;
            $orderName = $order->getDisplayName();
            $orderTotal = $order->total_amount;

            // Delete the order (this will also delete order items due to cascade)
            $order->delete();

            // Commit the transaction
            DB::commit();

            // Create notification for order deletion
            $userName = Auth::check() ? (is_object(Auth::user()) ? Auth::user()->name : 'Unknown User') : 'Unknown User';

            Notification::create([
                'title' => 'Order Deleted',
                'message' => 'Order "' . $orderName . '" for $' . number_format($orderTotal, 2) . ' has been deleted by ' . $userName,
                'type' => 'danger',
                'is_read' => false,
                // Removed 'link' field as it doesn't exist in the database
                'user_id' => Auth::id() ?? 1 // Default to user ID 1 if not authenticated
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
