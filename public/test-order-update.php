<?php
// Test script to update an order directly

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get the order ID from the query string
$orderId = $_GET['order_id'] ?? null;

// Get the new status from the query string
$newStatus = $_GET['status'] ?? null;

// Get the new name from the query string
$newName = $_GET['name'] ?? null;

// Validate inputs
if (!$orderId) {
    die('Error: No order ID provided. Use ?order_id=X in the URL.');
}

if (!$newStatus && !$newName) {
    die('Error: No status or name provided. Use ?status=X or ?name=Y in the URL.');
}

if ($newStatus && !in_array($newStatus, ['pending', 'processing', 'completed', 'cancelled'])) {
    die('Error: Invalid status. Must be one of: pending, processing, completed, cancelled.');
}

try {
    // Get the order
    $order = \App\Models\Order::find($orderId);
    
    if (!$order) {
        die("Error: Order with ID $orderId not found.");
    }
    
    // Log the current state
    echo "<h2>Before Update:</h2>";
    echo "<pre>";
    echo "Order ID: " . $order->id . "\n";
    echo "Status: " . $order->status . "\n";
    echo "Name: " . $order->name . "\n";
    echo "</pre>";
    
    // Update the order
    if ($newStatus) {
        $order->status = $newStatus;
    }
    
    if ($newName) {
        $order->name = $newName;
    }
    
    // Save the order
    $saveResult = $order->save();
    
    // Refresh the order from the database
    $order = \App\Models\Order::find($orderId);
    
    // Log the new state
    echo "<h2>After Update:</h2>";
    echo "<pre>";
    echo "Order ID: " . $order->id . "\n";
    echo "Status: " . $order->status . "\n";
    echo "Name: " . $order->name . "\n";
    echo "Save Result: " . ($saveResult ? 'Success' : 'Failed') . "\n";
    echo "</pre>";
    
    echo "<p>Order updated successfully!</p>";
    
} catch (\Exception $e) {
    echo "<h2>Error:</h2>";
    echo "<pre>";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "</pre>";
}
