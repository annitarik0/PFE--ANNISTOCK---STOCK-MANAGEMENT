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

    // Check if notifications table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'notifications'");
    $tableExists = $stmt->rowCount() > 0;

    if (!$tableExists) {
        echo "The 'notifications' table does not exist. Creating it now...\n";

        $sql = "CREATE TABLE notifications (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            message VARCHAR(255) NOT NULL,
            type VARCHAR(255) NOT NULL DEFAULT 'info',
            is_read TINYINT(1) NOT NULL DEFAULT 0,
            link VARCHAR(255) NULL,
            user_id BIGINT UNSIGNED NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";

        $pdo->exec($sql);
        echo "Table 'notifications' created successfully.\n";
    } else {
        echo "The 'notifications' table already exists.\n";

        // Get table structure
        $stmt = $pdo->query("DESCRIBE notifications");
        $columns = $stmt->fetchAll();

        echo "\nNotifications table structure:\n";
        foreach ($columns as $column) {
            echo "Field: {$column['Field']}, Type: {$column['Type']}, Null: {$column['Null']}, Key: {$column['Key']}, Default: {$column['Default']}, Extra: {$column['Extra']}\n";
        }
    }

    // List all notifications
    $stmt = $pdo->query("SELECT * FROM notifications");
    $notifications = $stmt->fetchAll();

    echo "\nAll notifications in the database:\n";
    if (count($notifications) > 0) {
        foreach ($notifications as $notification) {
            echo "ID: {$notification['id']}, Message: {$notification['message']}, Type: {$notification['type']}, Is Read: {$notification['is_read']}, Link: {$notification['link']}, User ID: {$notification['user_id']}\n";
        }
    } else {
        echo "No notifications found.\n";
    }

} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
