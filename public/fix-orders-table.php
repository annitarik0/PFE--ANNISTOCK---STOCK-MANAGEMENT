<?php
// Direct SQL script to fix the orders table

// Database connection parameters from .env
$host = '127.0.0.1';
$port = '3306';
$database = 'gestion_stock';
$username = 'root';
$password = '';

// Connect to the database directly
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Database Connection Successful</h1>";
    
    // Check if the name column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'name'");
    $nameColumnExists = $stmt->rowCount() > 0;
    
    echo "<h2>Current Table Structure:</h2>";
    $stmt = $pdo->query("DESCRIBE orders");
    echo "<pre>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
    echo "</pre>";
    
    if ($nameColumnExists) {
        echo "<p style='color: green;'>The 'name' column already exists in the orders table.</p>";
    } else {
        // Add the name column
        $pdo->exec("ALTER TABLE orders ADD COLUMN name VARCHAR(255) NULL AFTER user_id");
        
        echo "<p style='color: green;'>The 'name' column has been added to the orders table.</p>";
        
        // Verify the column was added
        echo "<h2>Updated Table Structure:</h2>";
        $stmt = $pdo->query("DESCRIBE orders");
        echo "<pre>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($row);
        }
        echo "</pre>";
    }
    
} catch (PDOException $e) {
    echo "<h1>Database Connection Failed</h1>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
