<?php
// Test script to update an order with a simple form

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get the order ID from the query string
$orderId = $_GET['order_id'] ?? null;

// Validate inputs
if (!$orderId) {
    die('Error: No order ID provided. Use ?order_id=X in the URL.');
}

try {
    // Get the order
    $order = \App\Models\Order::find($orderId);

    if (!$order) {
        die("Error: Order with ID $orderId not found.");
    }

    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newStatus = $_POST['status'] ?? null;
        $newName = $_POST['name'] ?? null;

        // Check if the name column exists in the orders table
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing('orders');
        $nameColumnExists = in_array('name', $columns);

        echo "<div style='background-color: #f8f9fa; padding: 15px; margin-bottom: 20px; border-radius: 4px;'>";
        echo "<p><strong>Columns in orders table:</strong></p>";
        echo "<pre>";
        print_r($columns);
        echo "</pre>";
        echo "<p><strong>Name column exists:</strong> " . ($nameColumnExists ? 'Yes' : 'No') . "</p>";
        echo "</div>";

        if ($newStatus && in_array($newStatus, ['pending', 'processing', 'completed', 'cancelled'])) {
            $order->status = $newStatus;
        }

        if ($newName !== null && $nameColumnExists) {
            $order->name = $newName;
        }

        $saveResult = $order->save();

        // Refresh the order from the database
        $order = \App\Models\Order::find($orderId);

        echo "<div style='background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;'>";
        echo "Order updated successfully!";
        echo "</div>";
    }

    // Display the current order details
    echo "<h2>Current Order Details:</h2>";
    echo "<div style='background-color: #f8f9fa; padding: 15px; margin-bottom: 20px; border-radius: 4px;'>";
    echo "<p><strong>Order ID:</strong> " . $order->id . "</p>";
    echo "<p><strong>Status:</strong> " . $order->status . "</p>";
    echo "<p><strong>Name:</strong> " . ($order->name ?: "Order #" . $order->id) . "</p>";
    echo "<p><strong>Total Amount:</strong> $" . number_format($order->total_amount, 2) . "</p>";
    echo "<p><strong>Created:</strong> " . $order->created_at . "</p>";
    echo "<p><strong>Updated:</strong> " . $order->updated_at . "</p>";
    echo "</div>";

    // Display the update form
    echo "<h2>Update Order:</h2>";
    echo "<form method='post' style='background-color: #f8f9fa; padding: 20px; border-radius: 4px;'>";

    // Add CSRF token
    echo "<input type='hidden' name='_token' value='" . csrf_token() . "'>";

    // Order Name
    echo "<div style='margin-bottom: 15px;'>";
    echo "<label for='name' style='display: block; margin-bottom: 5px; font-weight: bold;'>Order Name:</label>";
    echo "<input type='text' name='name' id='name' value='" . htmlspecialchars($order->name ?: '') . "' style='width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;'>";
    echo "<small style='color: #6c757d;'>If left blank, the order will be named 'Order #" . $order->id . "'</small>";
    echo "</div>";

    // Order Status
    echo "<div style='margin-bottom: 15px;'>";
    echo "<label for='status' style='display: block; margin-bottom: 5px; font-weight: bold;'>Order Status:</label>";
    echo "<select name='status' id='status' style='width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;'>";
    echo "<option value='pending'" . ($order->status === 'pending' ? ' selected' : '') . ">Pending</option>";
    echo "<option value='processing'" . ($order->status === 'processing' ? ' selected' : '') . ">Processing</option>";
    echo "<option value='completed'" . ($order->status === 'completed' ? ' selected' : '') . ">Completed</option>";
    echo "<option value='cancelled'" . ($order->status === 'cancelled' ? ' selected' : '') . ">Cancelled</option>";
    echo "</select>";
    echo "</div>";

    // Submit Button
    echo "<button type='submit' style='background-color: #4b6cb7; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;'>";
    echo "<i style='margin-right: 5px;'>💾</i> Update Order";
    echo "</button>";

    echo "</form>";

} catch (\Exception $e) {
    echo "<h2>Error:</h2>";
    echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px;'>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
}
