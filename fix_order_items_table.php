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
    
    // Check if order_items table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'order_items'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "Order_items table exists.\n";
        
        // Show current table structure
        echo "\nCurrent order_items table structure:\n";
        $stmt = $pdo->query("DESCRIBE order_items");
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
        
        // Check if quantity column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM order_items LIKE 'quantity'");
        $columnExists = $stmt->rowCount() > 0;
        
        if (!$columnExists) {
            echo "Adding quantity column to order_items table...\n";
            $pdo->exec("ALTER TABLE order_items ADD COLUMN quantity INT NOT NULL DEFAULT 1 AFTER product_id");
            echo "Quantity column added successfully.\n";
        } else {
            echo "Quantity column already exists.\n";
        }
        
        // Check if price column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM order_items LIKE 'price'");
        $columnExists = $stmt->rowCount() > 0;
        
        if (!$columnExists) {
            echo "Adding price column to order_items table...\n";
            $pdo->exec("ALTER TABLE order_items ADD COLUMN price DECIMAL(10,2) NOT NULL AFTER quantity");
            echo "Price column added successfully.\n";
        } else {
            echo "Price column already exists.\n";
        }
        
        // Get all order_items
        $stmt = $pdo->query("SELECT * FROM order_items");
        $orderItems = $stmt->fetchAll();
        
        if (count($orderItems) > 0) {
            echo "\nOrder items in the database:\n";
            echo str_repeat('-', 80) . "\n";
            echo sprintf("%-5s %-10s %-10s %-10s %-10s\n", "ID", "Order ID", "Product ID", "Quantity", "Price");
            echo str_repeat('-', 80) . "\n";
            
            foreach ($orderItems as $item) {
                echo sprintf("%-5s %-10s %-10s %-10s %-10s\n", 
                    $item['id'] ?? 'N/A', 
                    $item['order_id'] ?? 'N/A', 
                    $item['product_id'] ?? 'N/A',
                    $item['quantity'] ?? 'N/A',
                    $item['price'] ?? 'N/A'
                );
            }
            echo str_repeat('-', 80) . "\n";
        } else {
            echo "No order items found in the database.\n";
        }
        
    } else {
        echo "Order_items table does not exist. Creating it...\n";
        
        // Create order_items table
        $pdo->exec("CREATE TABLE order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            price DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
        )");
        
        echo "Order_items table created successfully!\n";
    }
    
    // Show updated table structure
    echo "\nUpdated order_items table structure:\n";
    $stmt = $pdo->query("DESCRIBE order_items");
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
    
    echo "Order_items table structure fixed successfully!\n";
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
