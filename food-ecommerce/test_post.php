<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

try {
    echo "Sending request...\n";
    $response = Http::post('http://127.0.0.1:8000/ingest/products/bulk', [
        [
            'product_id' => '999',
            'name' => 'Test',
            'description' => 'Test',
            'price' => 100,
            'unit' => 'kg',
            'category' => 'Test'
        ]
    ]);
    echo "Response status: " . $response->status() . "\n";
    echo "Response body: " . $response->body() . "\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
