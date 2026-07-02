<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Default DB connection: " . config('database.default') . "\n";
$connection = config('database.default');
$config = config("database.connections.{$connection}");
echo "Database Config:\n";
print_r($config);

try {
    $count = \App\Models\Product::count();
    echo "Product count: " . $count . "\n";
} catch (\Throwable $e) {
    echo "Error querying products: " . $e->getMessage() . "\n";
}
