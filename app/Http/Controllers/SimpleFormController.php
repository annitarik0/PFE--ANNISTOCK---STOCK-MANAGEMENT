<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SimpleFormController extends Controller
{
    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        // Get all products for the order form
        $products = Product::where('quantity', '>', 0)->get();
        return view('orders.simple-form', compact('products'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_select' => 'required|array',
            'quantity' => 'required|array',
        ]);

        // Start transaction
        DB::beginTransaction();

        try {
            // Create order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->status = 'pending';
            // Removed notes field as it doesn't exist in the database
            $order->total_amount = 0;
            $order->save();

            $totalAmount = 0;
            $productIds = $request->product_select;
            $quantities = $request->quantity;

            // Add order items
            foreach ($productIds as $productId) {
                // Get product
                $product = Product::find($productId);
                if (!$product) {
                    throw new \Exception("Product not found");
                }

                // Get quantity
                $quantity = isset($quantities[$productId]) ? (int)$quantities[$productId] : 0;
                if ($quantity <= 0) {
                    throw new \Exception("Invalid quantity for product {$product->name}");
                }

                // Check stock
                if ($product->quantity < $quantity) {
                    throw new \Exception("Not enough stock for {$product->name}");
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

                // Add to total
                $totalAmount += ($product->price * $quantity);
            }

            // Update order total
            $order->total_amount = $totalAmount;
            $order->save();

            // Commit transaction
            DB::commit();

            // Return success
            return redirect('/orders')->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Return error
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
