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
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "Users table exists.\n";
        
        // Show current table structure
        echo "\nCurrent users table structure:\n";
        $stmt = $pdo->query("DESCRIBE users");
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
        
        // Check if image column exists
        $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'image'");
        $columnExists = $stmt->rowCount() > 0;
        
        if (!$columnExists) {
            echo "Adding image column to users table...\n";
            $pdo->exec("ALTER TABLE users ADD COLUMN image VARCHAR(255) NULL AFTER role");
            echo "Image column added successfully.\n";
        } else {
            echo "Image column already exists.\n";
        }
        
        // Show updated table structure
        echo "\nUpdated users table structure:\n";
        $stmt = $pdo->query("DESCRIBE users");
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
        
        echo "Users table structure fixed successfully!\n";
    } else {
        echo "Users table does not exist. Creating it...\n";
        
        // Create users table
        $pdo->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'employee') NOT NULL DEFAULT 'employee',
            image VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        echo "Users table created successfully!\n";
    }
    
    // Ensure admin user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['admin@example.com']);
    $adminUser = $stmt->fetch();
    
    if (!$adminUser) {
        echo "Admin user not found. Creating admin user...\n";
        $password = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Admin User', 'admin@example.com', $password, 'admin']);
        echo "Admin user created successfully.\n";
    } else {
        echo "Admin user already exists.\n";
    }
    
    echo "\nLogin credentials:\n";
    echo "Email: admin@example.com\n";
    echo "Password: admin123\n";
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
