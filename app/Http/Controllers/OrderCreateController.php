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
            'product_ids' => $request->product_ids,
            'quantities' => $request->quantities,
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);

        // Simplified order creation with minimal error-prone code
        try {
            // Validate the request with stricter rules for security
            $validated = $request->validate([
                'product_ids' => 'required|array',
                'product_ids.*' => 'required|integer|exists:products,id',
                'quantities' => 'required|array',
                'quantities.*' => 'required|integer|min:1',
                'name' => 'nullable|string|max:255',
                'notes' => 'nullable|string|max:500',
            ]);

            // Start a database transaction
            DB::beginTransaction();

            // Create a new order with direct attribute assignment
            $order = new Order();
            $order->user_id = Auth::id();
            $order->status = 'pending';

            // IMPORTANT: Directly set the name attribute
            $customerName = $request->input('name');
            $order->name = $customerName;

            // Ensure the name is set in the attributes array
            $order->setAttribute('name', $customerName);

            // Log the name being set
            \Log::info('Setting customer name directly', [
                'customer_name' => $customerName,
                'order_id' => 'not yet created'
            ]);

            $order->total_amount = 0; // Will be calculated later
            $order->save();

            // Force update the name in the database after saving
            DB::statement("UPDATE orders SET name = ? WHERE id = ?", [$customerName, $order->id]);
            \Log::info('Force updated name in database', [
                'order_id' => $order->id,
                'name' => $customerName
            ]);

            // Verify the order was created with the correct name
            $freshOrder = Order::find($order->id);
            \Log::info('Order created with name verification', [
                'order_id' => $freshOrder->id,
                'name_in_db' => $freshOrder->name,
                'customer_name_from_request' => $customerName,
                'display_name' => $freshOrder->getDisplayName()
            ]);

            // Log order creation with name
            \Log::info('Order created', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'name' => $order->name,
                'display_name' => $order->getDisplayName(),
                'status' => $order->status
            ]);

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

                // Get the display name which will include the customer name if provided
                $displayName = $order->getDisplayName();

                Notification::create([
                    'title' => 'New Order Created',
                    'message' => 'New order "' . $displayName . '" has been created by ' . $userName . ' for $' . number_format($totalAmount, 2),
                    'type' => 'success',
                    'is_read' => false,
                    'user_id' => Auth::id() ?? 1
                ]);
            } catch (\Exception $e) {
                // Just log notification errors, don't fail the whole process
                \Log::error('Failed to create notification: ' . $e->getMessage());
            }

            // Always redirect to orders index with success message
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

            // Always redirect back with error message
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
