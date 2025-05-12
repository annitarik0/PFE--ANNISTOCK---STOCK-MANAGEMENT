<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all users and create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Deleting all users...');
        
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Delete all users
            User::truncate();
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            // Create a new admin user
            User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]);
            
            $this->info('All users have been deleted and a new admin user has been created.');
            $this->info('Email: admin@gmail.com');
            $this->info('Password: 123456');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
