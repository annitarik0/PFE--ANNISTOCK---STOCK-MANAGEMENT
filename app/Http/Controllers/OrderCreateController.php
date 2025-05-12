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

class OrderCreateController extends Controller
{
    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        // Get all products for the order form
        $products = Product::where('quantity', '>', 0)->with('category')->get();

        return view('orders.pro-create', compact('products'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Log the request data for debugging
        \Log::info('Order creation request received', [
            'request_data' => $request->all(),
            'is_ajax' => $request->ajax(),
            'product_ids' => $request->product_ids,
            'quantities' => $request->quantities,
            'notes' => $request->notes,
            'user_id' => Auth::id(),
            'user_name' => Auth::user() ? Auth::user()->name : 'Unknown'
        ]);

        // Simplified order creation with minimal error-prone code
        try {
            // Validate the request with more lenient rules
            $validated = $request->validate([
                'product_ids' => 'required|array',
                'product_ids.*' => 'required',  // Just make sure they exist in the request
                'quantities' => 'required|array',
                'quantities.*' => 'required',   // Just make sure they exist in the request
                // Removed notes validation as it doesn't exist in the database
            ]);

            // Log successful validation
            \Log::info('Order validation passed', [
                'product_ids' => $request->product_ids,
                'quantities' => $request->quantities
            ]);

            // Start a database transaction
            DB::beginTransaction();

            // Create a new order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->status = 'pending';
            // Removed notes field as it doesn't exist in the database
            $order->total_amount = 0; // Will be calculated later
            $order->save();

            $totalAmount = 0;

            // Add order items
            foreach ($request->product_ids as $index => $productId) {
                try {
                    // Make sure the product exists
                    $product = Product::find($productId);
                    if (!$product) {
                        throw new \Exception("Product with ID {$productId} not found");
                    }

                    // Make sure we have a valid quantity
                    $quantity = isset($request->quantities[$index]) ? intval($request->quantities[$index]) : 0;
                    if ($quantity <= 0) {
                        throw new \Exception("Invalid quantity for product {$product->name}");
                    }

                    // Check if there's enough stock
                    if ($product->quantity < $quantity) {
                        throw new \Exception("Not enough stock for {$product->name}. Available: {$product->quantity}");
                    }

                    // Log product processing
                    \Log::info("Processing product", [
                        'product_id' => $productId,
                        'product_name' => $product->name,
                        'quantity' => $quantity,
                        'available' => $product->quantity
                    ]);
                } catch (\Exception $e) {
                    throw new \Exception("Error processing product: " . $e->getMessage());
                }

                // Create order item
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->quantity = $quantity; // This is now the validated quantity from above
                $orderItem->price = $product->price;
                $orderItem->save();

                // Log order item creation
                \Log::info("Order item created", [
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);

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
            try {
                $userName = Auth::check() ? (is_object(Auth::user()) ? Auth::user()->name : 'Unknown User') : 'Unknown User';

                Notification::create([
                    'title' => 'New Order Created',
                    'message' => 'New order #' . $order->id . ' has been created by ' . $userName . ' for $' . number_format($totalAmount, 2),
                    'type' => 'success',
                    'is_read' => false,
                    'user_id' => Auth::id() ?? 1
                ]);
            } catch (\Exception $e) {
                // Just log notification errors, don't fail the whole process
                \Log::error('Failed to create notification: ' . $e->getMessage());
            }

            // Handle AJAX requests differently
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'redirect' => route('orders.index')
                ]);
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

            // Handle AJAX requests differently
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'message' => 'Failed to create order: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
