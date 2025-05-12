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
    
    // Update admin@gmail.com password to 123456
    $email = 'admin@gmail.com';
    $password = password_hash('123456', PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    $result = $stmt->execute([$password, $email]);
    
    if ($result) {
        echo "Password updated successfully for {$email}\n";
    } else {
        echo "Failed to update password for {$email}\n";
    }
    
    // Check if admin@example.com exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['admin@example.com']);
    $adminUser = $stmt->fetch();
    
    if ($adminUser) {
        // Update admin@example.com password to 123456
        $email = 'admin@example.com';
        $password = password_hash('123456', PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $result = $stmt->execute([$password, $email]);
        
        if ($result) {
            echo "Password updated successfully for {$email}\n";
        } else {
            echo "Failed to update password for {$email}\n";
        }
    }
    
    // List all users
    $stmt = $pdo->query("SELECT id, name, email, role FROM users");
    $users = $stmt->fetchAll();
    
    echo "\nAll users in the database:\n";
    foreach ($users as $user) {
        echo "ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}, Role: {$user['role']}\n";
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
