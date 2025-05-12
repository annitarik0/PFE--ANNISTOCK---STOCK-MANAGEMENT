<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WorkingOrderController extends Controller
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
        // Dump and die to see what's being submitted
        // dd($request->all());

        // Basic validation - very minimal
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);

        // Start transaction
        DB::beginTransaction();

        try {
            // Create order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->status = 'pending';
            $order->notes = $request->notes ?? '';
            $order->total_amount = 0;
            $order->save();

            $totalAmount = 0;

            // Add order items
            foreach ($request->product_ids as $index => $productId) {
                // Get product
                $product = Product::find($productId);
                if (!$product) {
                    throw new \Exception("Product not found");
                }

                // Get quantity
                $quantity = isset($request->quantities[$index]) ? (int)$request->quantities[$index] : 0;
                if ($quantity <= 0) {
                    throw new \Exception("Invalid quantity");
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

            // Return success - always redirect to orders page
            return redirect('/orders')->with('success', 'Order created successfully');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            // Return error - always redirect back with error
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
