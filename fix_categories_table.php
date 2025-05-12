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
    
    // Check if categories table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'categories'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "Categories table exists.\n";
        
        // Show current table structure
        echo "\nCurrent categories table structure:\n";
        $stmt = $pdo->query("DESCRIBE categories");
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
        
        // Check if name column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM categories LIKE 'name'");
        $columnExists = $stmt->rowCount() > 0;
        
        if (!$columnExists) {
            echo "Adding name column to categories table...\n";
            $pdo->exec("ALTER TABLE categories ADD COLUMN name VARCHAR(100) NOT NULL AFTER id");
            echo "Name column added successfully.\n";
        } else {
            echo "Name column already exists.\n";
        }
        
        // Check if description column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM categories LIKE 'description'");
        $columnExists = $stmt->rowCount() > 0;
        
        if (!$columnExists) {
            echo "Adding description column to categories table...\n";
            $pdo->exec("ALTER TABLE categories ADD COLUMN description TEXT NULL AFTER name");
            echo "Description column added successfully.\n";
        } else {
            echo "Description column already exists.\n";
        }
        
        // Get all categories
        $stmt = $pdo->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll();
        
        if (count($categories) > 0) {
            echo "\nCategories in the database:\n";
            echo str_repeat('-', 80) . "\n";
            echo sprintf("%-5s %-30s %-40s\n", "ID", "Name", "Description");
            echo str_repeat('-', 80) . "\n";
            
            foreach ($categories as $category) {
                echo sprintf("%-5s %-30s %-40s\n", 
                    $category['id'] ?? 'N/A', 
                    $category['name'] ?? 'N/A', 
                    substr($category['description'] ?? 'N/A', 0, 40)
                );
            }
            echo str_repeat('-', 80) . "\n";
        } else {
            echo "No categories found in the database. Creating sample categories...\n";
            
            // Create sample categories
            $sampleCategories = [
                ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
                ['name' => 'Office Supplies', 'description' => 'Office stationery and supplies'],
                ['name' => 'Furniture', 'description' => 'Office and home furniture'],
                ['name' => 'Kitchen', 'description' => 'Kitchen appliances and utensils'],
                ['name' => 'Clothing', 'description' => 'Apparel and accessories']
            ];
            
            foreach ($sampleCategories as $category) {
                $stmt = $pdo->prepare("INSERT INTO categories (name, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
                $stmt->execute([$category['name'], $category['description']]);
                echo "Added category: {$category['name']}\n";
            }
            
            echo "Sample categories created successfully.\n";
        }
        
    } else {
        echo "Categories table does not exist. Creating it...\n";
        
        // Create categories table
        $pdo->exec("CREATE TABLE categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        echo "Categories table created successfully!\n";
        
        // Create sample categories
        echo "Creating sample categories...\n";
        
        $sampleCategories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
            ['name' => 'Office Supplies', 'description' => 'Office stationery and supplies'],
            ['name' => 'Furniture', 'description' => 'Office and home furniture'],
            ['name' => 'Kitchen', 'description' => 'Kitchen appliances and utensils'],
            ['name' => 'Clothing', 'description' => 'Apparel and accessories']
        ];
        
        foreach ($sampleCategories as $category) {
            $stmt = $pdo->prepare("INSERT INTO categories (name, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
            $stmt->execute([$category['name'], $category['description']]);
            echo "Added category: {$category['name']}\n";
        }
        
        echo "Sample categories created successfully.\n";
    }
    
    // Show updated table structure
    echo "\nUpdated categories table structure:\n";
    $stmt = $pdo->query("DESCRIBE categories");
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
    
    echo "Categories table structure fixed successfully!\n";
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
