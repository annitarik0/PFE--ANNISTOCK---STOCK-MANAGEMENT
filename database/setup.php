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

    // Create categories table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `categories` (
          `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `slug` varchar(255) NOT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `categories_name_unique` (`name`),
          UNIQUE KEY `categories_slug_unique` (`slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    echo "Categories table created or already exists.\n";

    // Create products table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `products` (
          `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `price` decimal(8,2) NOT NULL,
          `image` varchar(255) DEFAULT NULL,
          `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          `category_id` bigint(20) UNSIGNED NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `products_name_unique` (`name`),
          KEY `products_category_id_foreign` (`category_id`),
          CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    echo "Products table created or already exists.\n";

    // Check if image column exists in users table
    $stmt = $pdo->query("SHOW COLUMNS FROM `users` LIKE 'image'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE `users` ADD COLUMN `image` varchar(255) DEFAULT NULL AFTER `email`");
        echo "Added image column to users table.\n";
    } else {
        echo "Image column already exists in users table.\n";
    }

    // Check if role column exists in users table
    $stmt = $pdo->query("SHOW COLUMNS FROM `users` LIKE 'role'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE `users` ADD COLUMN `role` varchar(255) DEFAULT 'employee' AFTER `email`");
        echo "Added role column to users table.\n";
    } else {
        echo "Role column already exists in users table.\n";
    }

    // Create notifications table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `notifications` (
          `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `message` varchar(255) NOT NULL,
          `type` varchar(255) NOT NULL DEFAULT 'info',
          `is_read` tinyint(1) NOT NULL DEFAULT 0,
          `link` varchar(255) DEFAULT NULL,
          `user_id` bigint(20) UNSIGNED DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `notifications_user_id_foreign` (`user_id`),
          CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    echo "Notifications table created or already exists.\n";

    echo "Database setup completed successfully.\n";

} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
