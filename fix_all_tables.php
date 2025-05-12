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

    // Get all existing tables
    $stmt = $pdo->query("SHOW TABLES");
    $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Existing tables: " . implode(', ', $existingTables) . "\n\n";

    // Define required tables and their creation SQL
    $requiredTables = [
        'users' => "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'employe') NOT NULL DEFAULT 'employe',
            image VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",

        'categories' => "CREATE TABLE categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",

        'products' => "CREATE TABLE products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT NULL,
            category VARCHAR(50) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            quantity INT NOT NULL DEFAULT 0,
            category_id INT NULL,
            image VARCHAR(255) NULL,
            min_stock INT NOT NULL DEFAULT 10,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX (category),
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        )",

        'orders' => "CREATE TABLE orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            status ENUM('en_attente', 'valide', 'annule') NOT NULL DEFAULT 'en_attente',
            total_amount DECIMAL(10,2) DEFAULT 0.00,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )",

        'order_items' => "CREATE TABLE order_items (
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            unit_price DECIMAL(10,2) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            PRIMARY KEY (order_id, product_id),
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
        )",

        'notifications' => "CREATE TABLE notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            message TEXT NOT NULL,
            type VARCHAR(50) NOT NULL DEFAULT 'info',
            is_read TINYINT(1) NOT NULL DEFAULT 0,
            link VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )"
    ];

    // Check and create missing tables
    foreach ($requiredTables as $tableName => $createSql) {
        if (!in_array($tableName, $existingTables)) {
            echo "Creating missing table: $tableName\n";
            $pdo->exec($createSql);
            echo "Table $tableName created successfully.\n\n";

            // Add sample data for newly created tables
            if ($tableName == 'categories' && !in_array('categories', $existingTables)) {
                echo "Adding sample categories...\n";
                $sampleCategories = [
                    ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
                    ['name' => 'Office Supplies', 'description' => 'Office stationery and supplies'],
                    ['name' => 'Furniture', 'description' => 'Office and home furniture'],
                    ['name' => 'Kitchen', 'description' => 'Kitchen appliances and utensils'],
                    ['name' => 'Clothing', 'description' => 'Apparel and accessories']
                ];

                foreach ($sampleCategories as $category) {
                    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
                    $stmt->execute([$category['name'], $category['description']]);
                }
                echo "Sample categories added.\n\n";
            }

            if ($tableName == 'users' && !in_array('users', $existingTables)) {
                echo "Adding admin user...\n";
                $password = password_hash('admin123', PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute(['Admin User', 'admin@example.com', $password, 'admin']);
                echo "Admin user added.\n\n";
            }
        } else {
            echo "Table $tableName already exists.\n";

            // Check for missing columns in existing tables
            if ($tableName == 'orders') {
                $stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'total_amount'");
                if ($stmt->rowCount() == 0) {
                    echo "Adding missing total_amount column to orders table...\n";
                    $pdo->exec("ALTER TABLE orders ADD COLUMN total_amount DECIMAL(10,2) DEFAULT 0.00 AFTER status");
                    echo "Column total_amount added to orders table.\n";
                }
            }

            if ($tableName == 'order_items') {
                $stmt = $pdo->query("SHOW COLUMNS FROM order_items LIKE 'price'");
                if ($stmt->rowCount() == 0) {
                    echo "Adding missing price column to order_items table...\n";
                    $pdo->exec("ALTER TABLE order_items ADD COLUMN price DECIMAL(10,2) NOT NULL AFTER quantity");
                    echo "Column price added to order_items table.\n";
                }
            }

            if ($tableName == 'products') {
                $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'category_id'");
                if ($stmt->rowCount() == 0) {
                    echo "Adding missing category_id column to products table...\n";
                    $pdo->exec("ALTER TABLE products ADD COLUMN category_id INT NULL AFTER quantity");
                    echo "Column category_id added to products table.\n";
                }
            }

            if ($tableName == 'notifications') {
                $stmt = $pdo->query("SHOW COLUMNS FROM notifications LIKE 'link'");
                if ($stmt->rowCount() == 0) {
                    echo "Adding missing link column to notifications table...\n";
                    $pdo->exec("ALTER TABLE notifications ADD COLUMN link VARCHAR(255) NULL AFTER is_read");
                    echo "Column link added to notifications table.\n";
                }

                $stmt = $pdo->query("SHOW COLUMNS FROM notifications LIKE 'updated_at'");
                if ($stmt->rowCount() == 0) {
                    echo "Adding missing updated_at column to notifications table...\n";
                    $pdo->exec("ALTER TABLE notifications ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at");
                    echo "Column updated_at added to notifications table.\n";
                }
            }

            echo "\n";
        }
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
        echo "Admin user already exists. Updating password...\n";
        $password = password_hash('admin123', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$password, 'admin@example.com']);
        echo "Admin user password updated successfully.\n";
    }

    echo "\nLogin credentials:\n";
    echo "Email: admin@example.com\n";
    echo "Password: admin123\n\n";

    echo "All required tables have been checked and fixed.\n";

} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
