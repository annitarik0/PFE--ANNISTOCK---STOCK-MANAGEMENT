<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-database {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database if it does not exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databaseName = $this->argument('name') ?? config('database.connections.mysql.database');
        
        $this->info("Attempting to create database: {$databaseName}");
        
        try {
            // Create a connection without specifying a database
            $pdo = new PDO(
                'mysql:host=' . config('database.connections.mysql.host') . ';port=' . config('database.connections.mysql.port'),
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password')
            );
            
            // Set error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Check if database exists
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$databaseName}'");
            $databaseExists = $stmt->fetchColumn();
            
            if ($databaseExists) {
                $this->info("Database '{$databaseName}' already exists.");
            } else {
                // Create the database
                $pdo->exec("CREATE DATABASE `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $this->info("Database '{$databaseName}' created successfully!");
            }
            
            // Suggest next steps
            $this->info('Next steps:');
            $this->info('1. Run migrations: php artisan migrate');
            $this->info('2. Create admin user: php artisan app:create-admin');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create database!');
            $this->error('Error: ' . $e->getMessage());
            
            // Suggest solutions
            $this->info('Possible solutions:');
            $this->info('1. Make sure MySQL server is running');
            $this->info('2. Check database credentials in .env file');
            $this->info('3. Try using "localhost" instead of "127.0.0.1" for DB_HOST');
            $this->info('4. Make sure you have permissions to create databases');
            
            return 1;
        }
    }
}
