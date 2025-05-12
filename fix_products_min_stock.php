<?php

// Connect to the database
$host = '127.0.0.1';
$db   = 'gestion_stock';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected to database successfully.\n";
    
    // Check if products table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "Products table exists.\n";
        
        // Show current table structure
        echo "\nCurrent products table structure:\n";
        $stmt = $pdo->query("DESCRIBE products");
        $columns = $stmt->fetchAll();
        
        echo str_repeat('-', 80) . "\n";
        echo sprintf("%-20s %-20s %-10s %-10s %-20s\n", "Field", "Type", "Null", "Key", "Default");
        echo str_repeat('-', 80) . "\n";
        
        foreach ($columns as $column) {
            echo sprintf("%-20s %-20s %-10s %-10s %-20s\n", 
                $column['Field'], 
                $column['Type'], 
                $column['Null'], 
                $column['Key'], 
                $column['Default'] ?? 'NULL'
            );
        }
        echo str_repeat('-', 80) . "\n";
        
        // Check if min_stock column exists and is NOT NULL
        $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'min_stock'");
        $column = $stmt->fetch();
        
        if ($column && $column['Null'] === 'NO') {
            echo "Modifying min_stock column to allow NULL values...\n";
            $pdo->exec("ALTER TABLE products MODIFY COLUMN min_stock INT NULL");
            echo "min_stock column modified successfully.\n";
        } else {
            echo "min_stock column is already nullable or doesn't exist.\n";
        }
        
        // Show updated table structure
        echo "\nUpdated products table structure:\n";
        $stmt = $pdo->query("DESCRIBE products");
        $columns = $stmt->fetchAll();
        
        echo str_repeat('-', 80) . "\n";
        echo sprintf("%-20s %-20s %-10s %-10s %-20s\n", "Field", "Type", "Null", "Key", "Default");
        echo str_repeat('-', 80) . "\n";
        
        foreach ($columns as $column) {
            echo sprintf("%-20s %-20s %-10s %-10s %-20s\n", 
                $column['Field'], 
                $column['Type'], 
                $column['Null'], 
                $column['Key'], 
                $column['Default'] ?? 'NULL'
            );
        }
        echo str_repeat('-', 80) . "\n";
        
        echo "Products table structure fixed successfully!\n";
    } else {
        echo "Products table does not exist.\n";
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
