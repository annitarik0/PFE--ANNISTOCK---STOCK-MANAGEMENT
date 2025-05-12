<?php

// Database connection parameters
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

    // Create a new user
    $name = 'Admin User';
    $email = 'admin@example.com';
    $password = password_hash('password', PASSWORD_DEFAULT);
    $role = 'admin';

    // Check if user already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        echo "User with email {$email} already exists.\n";
    } else {
        // Insert the user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$name, $email, $password, $role]);

        echo "User created successfully with ID: " . $pdo->lastInsertId() . "\n";
    }

    // Create a regular employee user
    $name = 'Employee User';
    $email = 'employee@example.com';
    $password = password_hash('password', PASSWORD_DEFAULT);
    $role = 'employee';

    // Check if user already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        echo "User with email {$email} already exists.\n";
    } else {
        // Insert the user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$name, $email, $password, $role]);

        echo "User created successfully with ID: " . $pdo->lastInsertId() . "\n";
    }

    // List all users
    $stmt = $pdo->query("SELECT id, name, email, role FROM users");
    $users = $stmt->fetchAll();

    echo "\nAll users:\n";
    foreach ($users as $user) {
        echo "ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}, Role: {$user['role']}\n";
    }

} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
