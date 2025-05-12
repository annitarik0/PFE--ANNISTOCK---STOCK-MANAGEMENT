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
    
    // Check if notifications table exists
    $tableExists = $pdo->query("SHOW TABLES LIKE 'notifications'")->rowCount() > 0;
    
    if ($tableExists) {
        echo "Notifications table exists. Checking columns...\n";
        
        // Get column information
        $columns = [];
        $stmt = $pdo->query("SHOW COLUMNS FROM notifications");
        while ($row = $stmt->fetch()) {
            $columns[] = $row['Field'];
        }
        
        echo "Current columns: " . implode(', ', $columns) . "\n";
        
        // Check if type column exists
        if (!in_array('type', $columns)) {
            echo "Adding 'type' column...\n";
            $pdo->exec("ALTER TABLE notifications ADD COLUMN type VARCHAR(255) DEFAULT 'info' AFTER message");
            echo "Added 'type' column successfully.\n";
        } else {
            echo "'type' column already exists.\n";
        }
        
        // Check if user_id column exists
        if (!in_array('user_id', $columns)) {
            echo "Adding 'user_id' column...\n";
            $pdo->exec("ALTER TABLE notifications ADD COLUMN user_id BIGINT UNSIGNED NULL");
            $pdo->exec("ALTER TABLE notifications ADD CONSTRAINT fk_notifications_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL");
            echo "Added 'user_id' column successfully.\n";
        } else {
            echo "'user_id' column already exists.\n";
        }
    } else {
        echo "Notifications table does not exist. Creating it...\n";
        
        // Create notifications table
        $pdo->exec("
            CREATE TABLE notifications (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NULL,
                message TEXT NOT NULL,
                type VARCHAR(255) DEFAULT 'info',
                icon VARCHAR(255) NULL,
                is_read BOOLEAN DEFAULT FALSE,
                link VARCHAR(255) NULL,
                user_id BIGINT UNSIGNED NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            )
        ");
        
        echo "Created notifications table successfully.\n";
    }
    
    echo "Notifications table update completed successfully!\n";
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
