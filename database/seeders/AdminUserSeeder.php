<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing users
        User::truncate();

        // Create admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('All users have been deleted and a new admin user has been created.');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: 123456');
    }
}
