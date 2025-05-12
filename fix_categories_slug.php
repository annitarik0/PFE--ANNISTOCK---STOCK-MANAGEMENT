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
        
        // Check if slug column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM categories LIKE 'slug'");
        $columnExists = $stmt->rowCount() > 0;
        
        if (!$columnExists) {
            echo "Adding slug column to categories table...\n";
            $pdo->exec("ALTER TABLE categories ADD COLUMN slug VARCHAR(255) NULL AFTER name");
            echo "Slug column added successfully.\n";
            
            // Update existing categories with slugs
            echo "Updating existing categories with slugs...\n";
            $stmt = $pdo->query("SELECT id, name FROM categories");
            $categories = $stmt->fetchAll();
            
            foreach ($categories as $category) {
                $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $category['name']));
                $stmt = $pdo->prepare("UPDATE categories SET slug = ? WHERE id = ?");
                $stmt->execute([$slug, $category['id']]);
                echo "Updated category '{$category['name']}' with slug '{$slug}'\n";
            }
            
            echo "All existing categories updated with slugs.\n";
        } else {
            echo "Slug column already exists.\n";
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
    } else {
        echo "Categories table does not exist. Creating it...\n";
        
        // Create categories table
        $pdo->exec("CREATE TABLE categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(255) NULL,
            description TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        echo "Categories table created successfully!\n";
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
