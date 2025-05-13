<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {--force : Force creation even if it means deleting existing users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('force')) {
            if ($this->confirm('This will delete all existing users. Are you sure you want to continue?', false)) {
                $this->info('Deleting all existing users...');
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                User::truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } else {
                $this->info('Operation cancelled.');
                return;
            }
        }

        // Check if admin already exists
        $existingAdmin = User::where('email', 'admin@gmail.com')->first();
        if ($existingAdmin) {
            $this->info('Admin user already exists!');
            $this->info('Email: admin@gmail.com');
            return;
        }

        // Create admin user
        $this->info('Creating admin user...');
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        $this->info('Admin user created successfully!');
        $this->info('Email: admin@gmail.com');
        $this->info('Password: 123456');
    }
}
