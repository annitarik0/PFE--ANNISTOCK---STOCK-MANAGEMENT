<?php
// Script to modify the Order model to work without the name column

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
    
    // Check if the name column exists
    $columns = $connection->getSchemaBuilder()->getColumnListing('orders');
    $nameColumnExists = in_array('name', $columns);
    
    echo "<h2>Current Columns in Orders Table:</h2>";
    echo "<pre>";
    print_r($columns);
    echo "</pre>";
    
    echo "<p><strong>Name column exists:</strong> " . ($nameColumnExists ? 'Yes' : 'No') . "</p>";
    
    // Get the Order model file path
    $orderModelPath = __DIR__ . '/../app/Models/Order.php';
    
    // Read the current model file
    $orderModelContent = file_get_contents($orderModelPath);
    
    echo "<h2>Current Order Model:</h2>";
    echo "<pre>";
    echo htmlspecialchars($orderModelContent);
    echo "</pre>";
    
    // Modify the getDisplayName method to work without the name column
    if (!$nameColumnExists) {
        $newContent = str_replace(
            "public function getDisplayName(): string\n    {\n        return \$this->name ?? 'Order #' . \$this->id;\n    }",
            "public function getDisplayName(): string\n    {\n        return 'Order #' . \$this->id;\n    }",
            $orderModelContent
        );
        
        // Create a backup of the original file
        file_put_contents($orderModelPath . '.bak', $orderModelContent);
        
        // Write the modified content
        file_put_contents($orderModelPath, $newContent);
        
        echo "<h2>Modified Order Model:</h2>";
        echo "<pre>";
        echo htmlspecialchars($newContent);
        echo "</pre>";
        
        echo "<p style='color: green;'>The Order model has been modified to work without the name column.</p>";
    } else {
        echo "<p>No changes needed to the Order model.</p>";
    }
    
} catch (\Exception $e) {
    echo "<h2>Error:</h2>";
    echo "<pre>";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "</pre>";
}
