<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class VectorizeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rag:sync-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all products to the RAG service Vector DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting syncing products to Vector DB...');

        $baseUrl = env('RAG_SERVICE_URL', 'http://127.0.0.1:8000');

        // Chunk products to avoid memory issues and send bulk requests
        Product::with('category')->chunk(10, function ($products) use ($baseUrl) {
            $payload = [];
            foreach ($products as $product) {
                $payload[] = [
                    'product_id' => (string)$product->id,
                    'name' => $product->name,
                    'description' => $product->description ?? '',
                    'price' => (float)$product->price,
                    'unit' => $product->unit ?? 'sp',
                    'category' => $product->category?->name ?? 'Chưa phân loại',
                ];
            }

            try {
                $response = Http::timeout(300)->post("{$baseUrl}/ingest/products/bulk", $payload);
                if ($response->successful()) {
                    $this->info("Successfully synced " . count($products) . " products.");
                } else {
                    $this->error("Failed to sync products. Status: " . $response->status() . ", Body: " . $response->body());
                }
            } catch (\Throwable $e) {
                $this->error("Error sending request to RAG service: " . $e->getMessage());
            }
        });

        $this->info('Done syncing products!');
    }
}
