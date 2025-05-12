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

    // Get table structure
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll();

    echo "Users table structure:\n";
    foreach ($columns as $column) {
        echo "Field: {$column['Field']}, Type: {$column['Type']}, Null: {$column['Null']}, Key: {$column['Key']}, Default: {$column['Default']}, Extra: {$column['Extra']}\n";
    }

    // Check if image column exists
    $hasImageColumn = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'image') {
            $hasImageColumn = true;
            break;
        }
    }

    if (!$hasImageColumn) {
        echo "\nThe 'image' column does not exist in the users table. Adding it now...\n";
        $pdo->exec("ALTER TABLE users ADD COLUMN image VARCHAR(255) NULL AFTER email");
        echo "Column 'image' added successfully.\n";
    } else {
        echo "\nThe 'image' column already exists in the users table.\n";
    }

    // Check if role column exists
    $hasRoleColumn = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'role') {
            $hasRoleColumn = true;
            break;
        }
    }

    if (!$hasRoleColumn) {
        echo "\nThe 'role' column does not exist in the users table. Adding it now...\n";
        $pdo->exec("ALTER TABLE users ADD COLUMN role VARCHAR(255) NOT NULL DEFAULT 'employee' AFTER email");
        echo "Column 'role' added successfully.\n";
    } else {
        echo "\nThe 'role' column already exists in the users table.\n";
    }

} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
