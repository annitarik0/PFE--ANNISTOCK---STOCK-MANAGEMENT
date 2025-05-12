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
    
    // Create a test category
    $name = 'Electronics';
    $slug = 'electronics';
    
    // Check if category already exists
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE name = ?");
    $stmt->execute([$name]);
    $existingCategory = $stmt->fetch();
    
    $categoryId = 0;
    
    if ($existingCategory) {
        echo "Category '{$name}' already exists with ID: {$existingCategory['id']}.\n";
        $categoryId = $existingCategory['id'];
    } else {
        // Insert the category
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $stmt->execute([$name, $slug]);
        
        $categoryId = $pdo->lastInsertId();
        echo "Category created successfully with ID: {$categoryId}\n";
    }
    
    // Create a test product
    $name = 'Laptop';
    $price = 999.99;
    $quantity = 10;
    
    // Check if product already exists
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name = ?");
    $stmt->execute([$name]);
    $existingProduct = $stmt->fetch();
    
    if ($existingProduct) {
        echo "Product '{$name}' already exists with ID: {$existingProduct['id']}.\n";
    } else {
        // Insert the product
        $stmt = $pdo->prepare("INSERT INTO products (name, price, quantity, category_id, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$name, $price, $quantity, $categoryId]);
        
        echo "Product created successfully with ID: " . $pdo->lastInsertId() . "\n";
    }
    
    // Create another test product
    $name = 'Smartphone';
    $price = 699.99;
    $quantity = 20;
    
    // Check if product already exists
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name = ?");
    $stmt->execute([$name]);
    $existingProduct = $stmt->fetch();
    
    if ($existingProduct) {
        echo "Product '{$name}' already exists with ID: {$existingProduct['id']}.\n";
    } else {
        // Insert the product
        $stmt = $pdo->prepare("INSERT INTO products (name, price, quantity, category_id, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$name, $price, $quantity, $categoryId]);
        
        echo "Product created successfully with ID: " . $pdo->lastInsertId() . "\n";
    }
    
    // List all categories
    $stmt = $pdo->query("SELECT id, name, slug FROM categories");
    $categories = $stmt->fetchAll();
    
    echo "\nAll categories:\n";
    foreach ($categories as $category) {
        echo "ID: {$category['id']}, Name: {$category['name']}, Slug: {$category['slug']}\n";
    }
    
    // List all products
    $stmt = $pdo->query("SELECT p.id, p.name, p.price, p.quantity, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id");
    $products = $stmt->fetchAll();
    
    echo "\nAll products:\n";
    foreach ($products as $product) {
        echo "ID: {$product['id']}, Name: {$product['name']}, Price: \${$product['price']}, Quantity: {$product['quantity']}, Category: {$product['category_name']}\n";
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
