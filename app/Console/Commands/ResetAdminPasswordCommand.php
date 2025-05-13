<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-admin-password {email=admin@gmail.com} {password=123456}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the admin password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            
            if ($this->confirm('Do you want to create this admin user?', true)) {
                $user = User::create([
                    'name' => 'Admin',
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'admin',
                ]);
                
                $this->info("Admin user created successfully!");
            } else {
                return 1;
            }
        } else {
            // Update the password
            $user->password = Hash::make($password);
            $user->save();
            
            $this->info("Password for {$email} has been reset to: {$password}");
        }
        
        // Display user information
        $this->table(
            ['ID', 'Name', 'Email', 'Role'],
            [
                [
                    'ID' => $user->id,
                    'Name' => $user->name,
                    'Email' => $user->email,
                    'Role' => $user->role,
                ]
            ]
        );
        
        return 0;
    }
}
