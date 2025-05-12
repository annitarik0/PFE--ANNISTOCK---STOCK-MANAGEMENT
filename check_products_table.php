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
        
        // Get all products
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        
        if (count($products) > 0) {
            echo "\nProducts in the database:\n";
            echo str_repeat('-', 80) . "\n";
            echo sprintf("%-5s %-30s %-10s %-10s %-15s\n", "ID", "Name", "Price", "Quantity", "Category ID");
            echo str_repeat('-', 80) . "\n";
            
            foreach ($products as $product) {
                echo sprintf("%-5s %-30s %-10s %-10s %-15s\n", 
                    $product['id'] ?? 'N/A', 
                    substr($product['name'] ?? 'N/A', 0, 30), 
                    $product['price'] ?? 'N/A',
                    $product['quantity'] ?? 'N/A',
                    $product['category_id'] ?? 'N/A'
                );
            }
            echo str_repeat('-', 80) . "\n";
        } else {
            echo "No products found in the database.\n";
        }
    } else {
        echo "Products table does not exist.\n";
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
