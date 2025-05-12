<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixProductsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-products-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the products table by adding missing columns';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Checking products table structure...');

            // Check if products table exists
            if (!Schema::hasTable('products')) {
                $this->error('Products table does not exist!');
                $this->info('Creating products table...');

                Schema::create('products', function ($table) {
                    $table->id();
                    $table->string('name');
                    $table->text('description')->nullable();
                    $table->decimal('price', 10, 2);
                    $table->integer('quantity')->default(0);
                    $table->unsignedBigInteger('category_id')->nullable();
                    $table->string('image')->nullable();
                    $table->timestamps();

                    $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
                });

                $this->info('Products table created successfully!');
                return Command::SUCCESS;
            }

            // Check if quantity column exists
            if (!Schema::hasColumn('products', 'quantity')) {
                $this->info('Adding quantity column to products table...');
                Schema::table('products', function ($table) {
                    $table->integer('quantity')->default(0)->after('price');
                });
                $this->info('Quantity column added successfully!');
            } else {
                $this->info('Quantity column already exists.');
            }

            // Check if description column exists
            if (!Schema::hasColumn('products', 'description')) {
                $this->info('Adding description column to products table...');
                Schema::table('products', function ($table) {
                    $table->text('description')->nullable()->after('name');
                });
                $this->info('Description column added successfully!');
            } else {
                $this->info('Description column already exists.');
            }

            // Check if image column exists
            if (!Schema::hasColumn('products', 'image')) {
                $this->info('Adding image column to products table...');
                Schema::table('products', function ($table) {
                    $table->string('image')->nullable()->after('category_id');
                });
                $this->info('Image column added successfully!');
            } else {
                $this->info('Image column already exists.');
            }

            // Show current table structure
            $columns = Schema::getColumnListing('products');
            $this->info('Current products table columns:');
            $this->table(['Column Name'], array_map(function($column) {
                return [$column];
            }, $columns));

            $this->info('Products table structure fixed successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
