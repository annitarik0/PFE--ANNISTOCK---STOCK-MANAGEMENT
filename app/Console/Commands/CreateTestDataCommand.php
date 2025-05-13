<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CreateTestDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test data for the application (categories and products)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test data...');

        // Create a test category
        $categoryName = 'Electronics';
        $categorySlug = Str::slug($categoryName);
        
        // Check if category already exists
        $existingCategory = Category::where('name', $categoryName)->first();
        
        if ($existingCategory) {
            $this->info("Category '{$categoryName}' already exists with ID: {$existingCategory->id}.");
            $categoryId = $existingCategory->id;
        } else {
            // Create the category
            $category = Category::create([
                'name' => $categoryName,
                'slug' => $categorySlug,
            ]);
            
            $categoryId = $category->id;
            $this->info("Category created successfully with ID: {$categoryId}");
        }
        
        // Create a test product: Laptop
        $productName = 'Laptop';
        $productPrice = 999.99;
        $productQuantity = 10;
        
        // Check if product already exists
        $existingProduct = Product::where('name', $productName)->first();
        
        if ($existingProduct) {
            $this->info("Product '{$productName}' already exists with ID: {$existingProduct->id}.");
        } else {
            // Create the product
            $product = Product::create([
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $productQuantity,
                'category_id' => $categoryId,
                'min_stock' => 2,
                'description' => 'A high-performance laptop for professional use',
                'sku' => 'LAP-' . rand(1000, 9999),
            ]);
            
            $this->info("Product created successfully with ID: {$product->id}");
        }
        
        // Create another test product: Smartphone
        $productName = 'Smartphone';
        $productPrice = 699.99;
        $productQuantity = 20;
        
        // Check if product already exists
        $existingProduct = Product::where('name', $productName)->first();
        
        if ($existingProduct) {
            $this->info("Product '{$productName}' already exists with ID: {$existingProduct->id}.");
        } else {
            // Create the product
            $product = Product::create([
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $productQuantity,
                'category_id' => $categoryId,
                'min_stock' => 5,
                'description' => 'A modern smartphone with advanced features',
                'sku' => 'PHN-' . rand(1000, 9999),
            ]);
            
            $this->info("Product created successfully with ID: {$product->id}");
        }
        
        // List all categories
        $this->info("\nAll categories:");
        $categories = Category::all();
        
        $this->table(
            ['ID', 'Name', 'Slug'],
            $categories->map(function ($category) {
                return [
                    'ID' => $category->id,
                    'Name' => $category->name,
                    'Slug' => $category->slug,
                ];
            })
        );
        
        // List all products
        $this->info("\nAll products:");
        $products = Product::with('category')->get();
        
        $this->table(
            ['ID', 'Name', 'Price', 'Quantity', 'Category'],
            $products->map(function ($product) {
                return [
                    'ID' => $product->id,
                    'Name' => $product->name,
                    'Price' => '$' . $product->price,
                    'Quantity' => $product->quantity,
                    'Category' => $product->category ? $product->category->name : 'None',
                ];
            })
        );
        
        $this->info('Test data creation completed successfully!');
    }
}
