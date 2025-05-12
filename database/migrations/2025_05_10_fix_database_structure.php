<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create categories table if it doesn't exist
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // Create products table if it doesn't exist
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->decimal('price', 8, 2);
                $table->string('image')->nullable();
                $table->integer('quantity')->unsigned()->default(1);
                $table->timestamps();
                $table->foreignId('category_id')
                    ->constrained('categories')
                    ->onDelete('cascade');
            });
        }

        // Add image column to users table if it doesn't exist
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('image')->nullable()->after('email');
            });
        }

        // Add role column to users table if it doesn't exist
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('employee')->after('email');
            });
        }

        // Create notifications table if it doesn't exist
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->string('message');
                $table->string('type')->default('info'); // info, success, warning, error
                $table->boolean('is_read')->default(false);
                $table->string('link')->nullable();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Update existing users with default role
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            User::whereNull('role')->orWhere('role', '')->update(['role' => 'employee']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration as it's just a fix
    }
};
