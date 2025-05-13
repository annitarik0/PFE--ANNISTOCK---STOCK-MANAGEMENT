<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CreateTestOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-order {user_id? : The ID of the user to create the order for} {--count=1 : Number of orders to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test order with random products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int)$this->option('count');
        if ($count < 1) {
            $count = 1;
        }
        
        $this->info("Creating {$count} test order(s)...");
        
        // Get user ID from argument or prompt for it
        $userId = $this->argument('user_id');
        if (!$userId) {
            // List available users
            $users = User::all();
            $this->info('Available users:');
            $this->table(
                ['ID', 'Name', 'Email', 'Role'],
                $users->map(function ($user) {
                    return [
                        'ID' => $user->id,
                        'Name' => $user->name,
                        'Email' => $user->email,
                        'Role' => $user->role,
                    ];
                })
            );
            
            $userId = $this->ask('Enter user ID for the order');
        }
        
        // Verify user exists
        $user = User::find($userId);
        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }
        
        // Get available products
        $products = Product::where('quantity', '>', 0)->get();
        if ($products->isEmpty()) {
            $this->error('No products available with quantity > 0.');
            return 1;
        }
        
        // Create orders
        for ($i = 0; $i < $count; $i++) {
            // Create a new order
            $order = new Order();
            $order->user_id = $user->id;
            $order->status = $this->getRandomStatus();
            $order->name = 'Test Order #' . time() . '-' . ($i + 1);
            $order->notes = 'This is a test order created via command line.';
            $order->save();
            
            // Add random products to the order
            $numProducts = rand(1, min(5, $products->count()));
            $orderProducts = $products->random($numProducts);
            
            $totalAmount = 0;
            
            foreach ($orderProducts as $product) {
                $quantity = rand(1, min(3, $product->quantity));
                
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->quantity = $quantity;
                $orderItem->price = $product->price;
                $orderItem->save();
                
                $totalAmount += $product->price * $quantity;
                
                // Update product quantity
                if ($order->status === 'completed') {
                    $product->quantity -= $quantity;
                    $product->save();
                }
            }
            
            // Update order total
            $order->total_amount = $totalAmount;
            $order->save();
            
            $this->info("Created order #{$order->id} with {$numProducts} products for user {$user->name}. Total: \${$totalAmount}");
        }
        
        $this->info('Test order creation completed successfully!');
        return 0;
    }
    
    /**
     * Get a random order status
     */
    private function getRandomStatus()
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $weights = [30, 20, 40, 10]; // Weighted probabilities
        
        $rand = rand(1, array_sum($weights));
        $current = 0;
        
        foreach ($statuses as $index => $status) {
            $current += $weights[$index];
            if ($rand <= $current) {
                return $status;
            }
        }
        
        return 'pending';
    }
}
