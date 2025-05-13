<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Str;

class FixTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-tables {table? : Specific table to fix (categories, products, orders, order_items, users, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix database tables structure and data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table') ?? 'all';
        
        switch ($table) {
            case 'categories':
                $this->fixCategoriesTable();
                break;
            case 'products':
                $this->fixProductsTable();
                break;
            case 'orders':
                $this->fixOrdersTable();
                break;
            case 'order_items':
                $this->fixOrderItemsTable();
                break;
            case 'users':
                $this->fixUsersTable();
                break;
            case 'all':
                $this->fixCategoriesTable();
                $this->fixProductsTable();
                $this->fixOrdersTable();
                $this->fixOrderItemsTable();
                $this->fixUsersTable();
                break;
            default:
                $this->error("Unknown table: {$table}");
                return 1;
        }
        
        $this->info('Table fixes completed successfully!');
        return 0;
    }
    
    /**
     * Fix the categories table
     */
    private function fixCategoriesTable()
    {
        $this->info('Fixing categories table...');
        
        // Add slug column if it doesn't exist
        if (!Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
            });
            $this->info('Added slug column to categories table.');
        }
        
        // Generate slugs for categories that don't have one
        $categories = Category::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($categories as $category) {
            $category->slug = Str::slug($category->name);
            $category->save();
        }
        $this->info("Generated slugs for {$categories->count()} categories.");
    }
    
    /**
     * Fix the products table
     */
    private function fixProductsTable()
    {
        $this->info('Fixing products table...');
        
        // Add min_stock column if it doesn't exist
        if (!Schema::hasColumn('products', 'min_stock')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('min_stock')->default(5)->after('quantity');
            });
            $this->info('Added min_stock column to products table.');
        }
        
        // Add description column if it doesn't exist
        if (!Schema::hasColumn('products', 'description')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('description')->nullable()->after('name');
            });
            $this->info('Added description column to products table.');
        }
        
        // Add SKU column if it doesn't exist
        if (!Schema::hasColumn('products', 'sku')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('sku')->nullable()->after('name');
            });
            $this->info('Added sku column to products table.');
            
            // Generate SKUs for products that don't have one
            $products = Product::whereNull('sku')->orWhere('sku', '')->get();
            foreach ($products as $product) {
                $product->sku = 'PRD-' . rand(10000, 99999);
                $product->save();
            }
            $this->info("Generated SKUs for {$products->count()} products.");
        }
    }
    
    /**
     * Fix the orders table
     */
    private function fixOrdersTable()
    {
        $this->info('Fixing orders table...');
        
        // Add name column if it doesn't exist
        if (!Schema::hasColumn('orders', 'name')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('name')->nullable()->after('id');
            });
            $this->info('Added name column to orders table.');
            
            // Generate names for orders that don't have one
            $orders = Order::whereNull('name')->orWhere('name', '')->get();
            foreach ($orders as $order) {
                $order->name = 'Order #' . $order->id;
                $order->save();
            }
            $this->info("Generated names for {$orders->count()} orders.");
        }
    }
    
    /**
     * Fix the order_items table
     */
    private function fixOrderItemsTable()
    {
        $this->info('Fixing order_items table...');
        
        // Add price column if it doesn't exist
        if (!Schema::hasColumn('order_items', 'price')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->decimal('price', 10, 2)->default(0)->after('product_id');
            });
            $this->info('Added price column to order_items table.');
            
            // Update prices for order items based on their products
            $orderItems = OrderItem::with('product')->get();
            foreach ($orderItems as $item) {
                if ($item->product) {
                    $item->price = $item->product->price;
                    $item->save();
                }
            }
            $this->info("Updated prices for {$orderItems->count()} order items.");
        }
    }
    
    /**
     * Fix the users table
     */
    private function fixUsersTable()
    {
        $this->info('Fixing users table...');
        
        // Add role column if it doesn't exist
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('employee')->after('email');
            });
            $this->info('Added role column to users table.');
        }
        
        // Add profile_image column if it doesn't exist
        if (!Schema::hasColumn('users', 'profile_image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_image')->nullable()->after('role');
            });
            $this->info('Added profile_image column to users table.');
        }
    }
}
