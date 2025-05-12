<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for debugging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'role' => 'employee',
            ]);

            $this->info('Test user created successfully:');
            $this->info("ID: {$user->id}");
            $this->info("Name: {$user->name}");
            $this->info("Email: {$user->email}");
            $this->info("Role: {$user->role}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error creating test user: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
