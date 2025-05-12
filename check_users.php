<?php

// Database connection parameters
$host = '127.0.0.1';
$db   = 'gestion_stock'; // Fixed database name with underscore instead of hyphen
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

    // Show table structure
    echo "\nUsers table structure:\n";
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

    // List all users
    $stmt = $pdo->query("SELECT id, name, email, role, password FROM users");
    $users = $stmt->fetchAll();

    echo "\nAll users in the database:\n";
    echo str_repeat('-', 80) . "\n";
    echo sprintf("%-5s %-20s %-30s %-15s %-10s\n", "ID", "Name", "Email", "Role", "Password (truncated)");
    echo str_repeat('-', 80) . "\n";

    foreach ($users as $userData) {
        // Truncate password for display
        $truncatedPassword = substr($userData['password'] ?? '', 0, 20) . '...';

        echo sprintf("%-5s %-20s %-30s %-15s %-10s\n",
            $userData['id'] ?? 'N/A',
            $userData['name'] ?? 'N/A',
            $userData['email'] ?? 'N/A',
            $userData['role'] ?? 'N/A',
            $truncatedPassword
        );
    }
    echo str_repeat('-', 80) . "\n";

    // Create a new admin user with email admin@example.com
    echo "\nCreating/updating admin user with email admin@example.com and password admin123\n";

    // Check if admin@example.com exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['admin@example.com']);
    $adminUser = $stmt->fetch();

    // Create a properly hashed password
    $password = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]);

    if ($adminUser) {
        echo "Admin user found. Updating password...\n";

        // Update existing admin user
        $stmt = $pdo->prepare("UPDATE users SET password = ?, role = 'admin', updated_at = NOW() WHERE email = ?");
        $stmt->execute([$password, 'admin@example.com']);

        echo "Admin user updated successfully.\n";
    } else {
        echo "Admin user not found. Creating new admin user...\n";

        // Create new admin user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute(['Admin User', 'admin@example.com', $password, 'admin']);

        echo "Admin user created successfully with ID: " . $pdo->lastInsertId() . "\n";
    }

    echo "\nYou can now login with:\n";
    echo "Email: admin@example.com\n";
    echo "Password: admin123\n";

} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
