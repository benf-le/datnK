<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncProductToVectorDb implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productId;
    protected $action;
    protected $productData;

    /**
     * Create a new job instance.
     */
    public function __construct($productId, $action, array $productData = [])
    {
        $this->productId = $productId;
        $this->action = $action;
        $this->productData = $productData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $baseUrl = env('RAG_SERVICE_URL', 'http://127.0.0.1:8000');

        if ($this->action === 'delete') {
            try {
                $response = Http::delete("{$baseUrl}/ingest/product/{$this->productId}");
                if (!$response->successful()) {
                    Log::error("Failed to delete product from vector DB. ID: {$this->productId}, Response: " . $response->body());
                }
            } catch (\Throwable $e) {
                Log::error("Error deleting product from vector DB: " . $e->getMessage());
            }
        } else {
            // Action is saved/upsert
            if (empty($this->productData)) {
                $product = Product::with('category')->find($this->productId);
                if (!$product) {
                    Log::warning("Product not found for vector sync. ID: {$this->productId}");
                    return;
                }
                $this->productData = [
                    'product_id' => (string)$product->id,
                    'name' => $product->name,
                    'description' => $product->description ?? '',
                    'price' => (float)$product->price,
                    'unit' => $product->unit ?? 'sp',
                    'category' => $product->category?->name ?? 'Chưa phân loại',
                ];
            }

            try {
                $response = Http::post("{$baseUrl}/ingest/product", $this->productData);
                if (!$response->successful()) {
                    Log::error("Failed to sync product to vector DB. ID: {$this->productId}, Response: " . $response->body());
                }
            } catch (\Throwable $e) {
                Log::error("Error syncing product to vector DB: " . $e->getMessage());
            }
        }
    }
}
