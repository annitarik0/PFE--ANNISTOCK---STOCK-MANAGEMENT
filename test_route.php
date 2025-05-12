<?php

// Bootstrap the Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the route information
$routes = Route::getRoutes();

echo "Testing route: users.create\n";
try {
    $url = route('users.create');
    echo "Route URL: " . $url . "\n";
    
    // Get the route details
    $route = $routes->getByName('users.create');
    if ($route) {
        echo "Route exists!\n";
        echo "Controller: " . $route->getActionName() . "\n";
        echo "Middleware: " . implode(', ', $route->middleware()) . "\n";
    } else {
        echo "Route does not exist!\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// List all routes with 'users' in the name
echo "\nAll routes with 'users' in the name:\n";
foreach ($routes as $route) {
    $name = $route->getName();
    if ($name && strpos($name, 'users') !== false) {
        echo $name . " => " . $route->uri() . " (Controller: " . $route->getActionName() . ")\n";
    }
}
