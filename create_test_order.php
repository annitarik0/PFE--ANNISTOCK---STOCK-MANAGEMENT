<?php

// Database connection parameters
$host = '127.0.0.1';
$db   = 'gestion-stock';
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
    
    // Get a user
    $stmt = $pdo->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
    $user = $stmt->fetch();
    
    if (!$user) {
        echo "No admin user found. Please create an admin user first.\n";
        exit(1);
    }
    
    $userId = $user['id'];
    
    // Get products
    $stmt = $pdo->query("SELECT id, price, quantity FROM products LIMIT 2");
    $products = $stmt->fetchAll();
    
    if (count($products) < 2) {
        echo "Not enough products found. Please create at least 2 products first.\n";
        exit(1);
    }
    
    // Start a transaction
    $pdo->beginTransaction();
    
    try {
        // Create an order
        $totalAmount = 0;
        $status = 'pending';
        $notes = 'Test order created via script';
        
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, notes, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$userId, $totalAmount, $status, $notes]);
        
        $orderId = $pdo->lastInsertId();
        
        // Create order items
        foreach ($products as $product) {
            $productId = $product['id'];
            $price = $product['price'];
            $quantity = 1; // Order 1 of each product
            
            // Check if there's enough stock
            if ($product['quantity'] < $quantity) {
                throw new \Exception("Not enough stock for product ID {$productId}");
            }
            
            // Create order item
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$orderId, $productId, $quantity, $price]);
            
            // Update product quantity
            $stmt = $pdo->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
            $stmt->execute([$quantity, $productId]);
            
            // Add to total amount
            $totalAmount += ($price * $quantity);
        }
        
        // Update order total
        $stmt = $pdo->prepare("UPDATE orders SET total_amount = ? WHERE id = ?");
        $stmt->execute([$totalAmount, $orderId]);
        
        // Commit the transaction
        $pdo->commit();
        
        echo "Order created successfully with ID: {$orderId}\n";
        echo "Total amount: \${$totalAmount}\n";
        
        // List order items
        $stmt = $pdo->prepare("
            SELECT oi.id, p.name, oi.quantity, oi.price, (oi.quantity * oi.price) as subtotal
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        $orderItems = $stmt->fetchAll();
        
        echo "\nOrder items:\n";
        foreach ($orderItems as $item) {
            echo "ID: {$item['id']}, Product: {$item['name']}, Quantity: {$item['quantity']}, Price: \${$item['price']}, Subtotal: \${$item['subtotal']}\n";
        }
        
    } catch (\Exception $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();
        throw $e;
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
