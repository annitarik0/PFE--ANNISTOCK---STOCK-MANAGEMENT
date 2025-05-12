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
    
    // Check if cache table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'cache'");
    $cacheTableExists = $stmt->rowCount() > 0;
    
    if (!$cacheTableExists) {
        echo "The 'cache' table does not exist. Creating it now...\n";
        
        $sql = "CREATE TABLE `cache` (
            `key` VARCHAR(255) NOT NULL,
            `value` MEDIUMTEXT NOT NULL,
            `expiration` INT NOT NULL,
            PRIMARY KEY (`key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "Table 'cache' created successfully.\n";
    } else {
        echo "The 'cache' table already exists.\n";
    }
    
    // Check if cache_locks table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'cache_locks'");
    $cacheLockTableExists = $stmt->rowCount() > 0;
    
    if (!$cacheLockTableExists) {
        echo "The 'cache_locks' table does not exist. Creating it now...\n";
        
        $sql = "CREATE TABLE `cache_locks` (
            `key` VARCHAR(255) NOT NULL,
            `owner` VARCHAR(255) NOT NULL,
            `expiration` INT NOT NULL,
            PRIMARY KEY (`key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "Table 'cache_locks' created successfully.\n";
    } else {
        echo "The 'cache_locks' table already exists.\n";
    }
    
    // Check if sessions table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'sessions'");
    $sessionsTableExists = $stmt->rowCount() > 0;
    
    if (!$sessionsTableExists) {
        echo "The 'sessions' table does not exist. Creating it now...\n";
        
        $sql = "CREATE TABLE `sessions` (
            `id` VARCHAR(255) NOT NULL,
            `user_id` BIGINT UNSIGNED NULL,
            `ip_address` VARCHAR(45) NULL,
            `user_agent` TEXT NULL,
            `payload` TEXT NOT NULL,
            `last_activity` INT NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "Table 'sessions' created successfully.\n";
    } else {
        echo "The 'sessions' table already exists.\n";
    }
    
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
