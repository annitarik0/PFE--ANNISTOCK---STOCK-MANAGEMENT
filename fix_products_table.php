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

        // Check if quantity column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'quantity'");
        $columnExists = $stmt->rowCount() > 0;

        if (!$columnExists) {
            echo "Adding quantity column to products table...\n";
            $pdo->exec("ALTER TABLE products ADD COLUMN quantity INT DEFAULT 0 AFTER price");
            echo "Quantity column added successfully.\n";
        } else {
            echo "Quantity column already exists.\n";
        }

        // Check if description column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'description'");
        $columnExists = $stmt->rowCount() > 0;

        if (!$columnExists) {
            echo "Adding description column to products table...\n";
            $pdo->exec("ALTER TABLE products ADD COLUMN description TEXT AFTER name");
            echo "Description column added successfully.\n";
        } else {
            echo "Description column already exists.\n";
        }

        // Check if category_id column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'category_id'");
        $columnExists = $stmt->rowCount() > 0;

        if (!$columnExists) {
            echo "Adding category_id column to products table...\n";
            $pdo->exec("ALTER TABLE products ADD COLUMN category_id BIGINT UNSIGNED DEFAULT NULL AFTER quantity");
            echo "Category_id column added successfully.\n";
        } else {
            echo "Category_id column already exists.\n";
        }

        // Check if image column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'image'");
        $columnExists = $stmt->rowCount() > 0;

        if (!$columnExists) {
            echo "Adding image column to products table...\n";
            $pdo->exec("ALTER TABLE products ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER category_id");
            echo "Image column added successfully.\n";
        } else {
            echo "Image column already exists.\n";
        }

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
        echo "Products table structure fixed successfully!\n";
    } else {
        echo "Products table does not exist. Creating it...\n";

        // Create products table
        $pdo->exec("CREATE TABLE products (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            quantity INT DEFAULT 0,
            category_id BIGINT UNSIGNED,
            image VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        )");

        echo "Products table created successfully!\n";
    }

} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
