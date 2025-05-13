<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database connection and display configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking database connection...');
        
        // Display database configuration
        $this->info('Database Configuration:');
        $this->info('Connection: ' . config('database.default'));
        $this->info('Host: ' . config('database.connections.mysql.host'));
        $this->info('Port: ' . config('database.connections.mysql.port'));
        $this->info('Database: ' . config('database.connections.mysql.database'));
        $this->info('Username: ' . config('database.connections.mysql.username'));
        
        // Try to connect to the database
        try {
            DB::connection()->getPdo();
            $this->info('Database connection successful!');
            $this->info('Connected to database: ' . DB::connection()->getDatabaseName());
            
            // Check if users table exists
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map(function($table) {
                return array_values((array)$table)[0];
            }, $tables);
            
            $this->info('Tables in database:');
            foreach ($tableNames as $tableName) {
                $this->info('- ' . $tableName);
            }
            
            if (in_array('users', $tableNames)) {
                $userCount = DB::table('users')->count();
                $this->info('Number of users in the database: ' . $userCount);
                
                if ($userCount > 0) {
                    $users = DB::table('users')->get();
                    $this->table(
                        ['ID', 'Name', 'Email', 'Role'],
                        $users->map(function ($user) {
                            return [
                                'ID' => $user->id,
                                'Name' => $user->name,
                                'Email' => $user->email,
                                'Role' => $user->role ?? 'N/A',
                            ];
                        })
                    );
                }
            } else {
                $this->warn('Users table does not exist!');
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Database connection failed!');
            $this->error('Error: ' . $e->getMessage());
            
            // Suggest solutions
            $this->info('Possible solutions:');
            $this->info('1. Make sure MySQL server is running');
            $this->info('2. Check database credentials in .env file');
            $this->info('3. Try using "localhost" instead of "127.0.0.1" for DB_HOST');
            $this->info('4. Make sure the database exists');
            
            return 1;
        }
    }
}
