<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the role column exists
        if (Schema::hasColumn('users', 'role')) {
            // Update all users with null or empty role to have 'employee' role
            User::whereNull('role')->orWhere('role', '')->update(['role' => 'employee']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration as it's just updating data
    }
};
