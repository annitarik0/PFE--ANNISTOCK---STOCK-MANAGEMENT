<?php

// Bootstrap the Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Delete all existing users
echo "Deleting all existing users...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
User::truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// Create admin user
echo "Creating admin user...\n";
$user = User::create([
    'name' => 'admin',
    'email' => 'admin@gmail.com',
    'password' => Hash::make('123456'),
    'role' => 'admin',
]);

echo "Admin user created successfully!\n";
echo "Email: admin@gmail.com\n";
echo "Password: 123456\n";
