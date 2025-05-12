<?php

// Connect to the database
$host = 'localhost';
$db = 'gestion_stock';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Create sample categories
    $categories = [
        ['name' => 'Electronics', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ['name' => 'Clothing', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ['name' => 'Books', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ['name' => 'Home & Kitchen', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ['name' => 'Sports', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO categories (name, created_at, updated_at) VALUES (?, ?, ?)");
    
    foreach ($categories as $category) {
        $stmt->execute([$category['name'], $category['created_at'], $category['updated_at']]);
    }
    
    echo "Sample categories created.\n";
    
    // Get category IDs
    $stmt = $pdo->query("SELECT id FROM categories");
    $categoryIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Create sample products
    $products = [
        [
            'name' => 'Laptop',
            'price' => 999.99,
            'image' => 'laptop.jpg',
            'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
            'quantity' => 10,
            'category_id' => $categoryIds[0], // Electronics
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Smartphone',
            'price' => 699.99,
            'image' => 'smartphone.jpg',
            'description' => 'Latest smartphone with 128GB storage and 5G capability',
            'quantity' => 15,
            'category_id' => $categoryIds[0], // Electronics
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'T-Shirt',
            'price' => 19.99,
            'image' => 'tshirt.jpg',
            'description' => 'Cotton t-shirt available in various colors',
            'quantity' => 50,
            'category_id' => $categoryIds[1], // Clothing
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Novel',
            'price' => 12.99,
            'image' => 'novel.jpg',
            'description' => 'Bestselling novel by a renowned author',
            'quantity' => 30,
            'category_id' => $categoryIds[2], // Books
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Coffee Maker',
            'price' => 49.99,
            'image' => 'coffeemaker.jpg',
            'description' => 'Automatic coffee maker with timer',
            'quantity' => 20,
            'category_id' => $categoryIds[3], // Home & Kitchen
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Basketball',
            'price' => 29.99,
            'image' => 'basketball.jpg',
            'description' => 'Official size basketball',
            'quantity' => 25,
            'category_id' => $categoryIds[4], // Sports
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO products (name, price, image, description, quantity, category_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($products as $product) {
        $stmt->execute([
            $product['name'],
            $product['price'],
            $product['image'],
            $product['description'],
            $product['quantity'],
            $product['category_id'],
            $product['created_at'],
            $product['updated_at']
        ]);
    }
    
    echo "Sample products created.\n";
    
    echo "All sample data has been created successfully!\n";
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
