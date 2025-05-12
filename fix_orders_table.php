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
    
    // Check if orders table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'orders'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "Orders table exists.\n";
        
        // Show current table structure
        echo "\nCurrent orders table structure:\n";
        $stmt = $pdo->query("DESCRIBE orders");
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
        
        // Check if total_amount column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'total_amount'");
        $columnExists = $stmt->rowCount() > 0;
        
        if (!$columnExists) {
            echo "Adding total_amount column to orders table...\n";
            $pdo->exec("ALTER TABLE orders ADD COLUMN total_amount DECIMAL(10,2) DEFAULT 0.00 AFTER status");
            echo "Total_amount column added successfully.\n";
            
            // Update existing orders with calculated total_amount
            echo "Updating existing orders with calculated total_amount...\n";
            
            // First check if order_items table exists
            $stmt = $pdo->query("SHOW TABLES LIKE 'order_items'");
            $orderItemsTableExists = $stmt->rowCount() > 0;
            
            if ($orderItemsTableExists) {
                // Get all orders
                $orders = $pdo->query("SELECT id FROM orders")->fetchAll();
                
                foreach ($orders as $order) {
                    $orderId = $order['id'];
                    
                    // Calculate total amount from order_items
                    $stmt = $pdo->prepare("
                        SELECT SUM(quantity * price) as total 
                        FROM order_items 
                        WHERE order_id = ?
                    ");
                    $stmt->execute([$orderId]);
                    $result = $stmt->fetch();
                    $totalAmount = $result['total'] ?? 0;
                    
                    // Update order with calculated total
                    $updateStmt = $pdo->prepare("
                        UPDATE orders 
                        SET total_amount = ? 
                        WHERE id = ?
                    ");
                    $updateStmt->execute([$totalAmount, $orderId]);
                    
                    echo "Updated order #$orderId with total amount: $totalAmount\n";
                }
                
                echo "All existing orders updated with calculated total_amount.\n";
            } else {
                echo "Order_items table does not exist. Cannot calculate total_amount for existing orders.\n";
            }
        } else {
            echo "Total_amount column already exists.\n";
        }
        
        // Check if status column exists and has the correct type
        $stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'status'");
        $statusExists = $stmt->rowCount() > 0;
        
        if ($statusExists) {
            $statusColumn = $stmt->fetch();
            echo "Status column type: " . $statusColumn['Type'] . "\n";
            
            // If status is not ENUM or VARCHAR, modify it
            if (strpos(strtolower($statusColumn['Type']), 'enum') === false && 
                strpos(strtolower($statusColumn['Type']), 'varchar') === false) {
                echo "Modifying status column to VARCHAR...\n";
                $pdo->exec("ALTER TABLE orders MODIFY COLUMN status VARCHAR(20) DEFAULT 'pending'");
                echo "Status column modified successfully.\n";
            }
        } else {
            echo "Adding status column to orders table...\n";
            $pdo->exec("ALTER TABLE orders ADD COLUMN status VARCHAR(20) DEFAULT 'pending' AFTER user_id");
            echo "Status column added successfully.\n";
        }
        
        // Show updated table structure
        echo "\nUpdated orders table structure:\n";
        $stmt = $pdo->query("DESCRIBE orders");
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
        echo "Orders table structure fixed successfully!\n";
    } else {
        echo "Orders table does not exist. Creating it...\n";
        
        // Create orders table
        $pdo->exec("CREATE TABLE orders (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            status VARCHAR(20) DEFAULT 'pending',
            total_amount DECIMAL(10,2) DEFAULT 0.00,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");
        
        echo "Orders table created successfully!\n";
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
