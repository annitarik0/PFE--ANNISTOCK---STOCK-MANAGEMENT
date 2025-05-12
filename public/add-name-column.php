<?php
// Script to add the name column to the orders table directly

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

try {
    // Get the database connection
    $connection = \DB::connection();
    
    // Check if the name column already exists
    $columns = $connection->getSchemaBuilder()->getColumnListing('orders');
    
    echo "<h2>Current Columns in Orders Table:</h2>";
    echo "<pre>";
    print_r($columns);
    echo "</pre>";
    
    if (in_array('name', $columns)) {
        echo "<p style='color: green;'>The 'name' column already exists in the orders table.</p>";
    } else {
        // Add the name column
        $connection->statement('ALTER TABLE orders ADD COLUMN name VARCHAR(255) NULL AFTER user_id');
        
        echo "<p style='color: green;'>The 'name' column has been added to the orders table.</p>";
        
        // Verify the column was added
        $columns = $connection->getSchemaBuilder()->getColumnListing('orders');
        
        echo "<h2>Updated Columns in Orders Table:</h2>";
        echo "<pre>";
        print_r($columns);
        echo "</pre>";
    }
    
} catch (\Exception $e) {
    echo "<h2>Error:</h2>";
    echo "<pre>";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "</pre>";
}
