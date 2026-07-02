<?php

namespace App\Observers;

use App\Models\Product;
use App\Jobs\SyncProductToVectorDb;

class ProductObserver
{
    /**
     * Handle the Product "saved" event.
     */
    public function saved(Product $product): void
    {
        $productData = [
            'product_id' => (string)$product->id,
            'name' => $product->name,
            'description' => $product->description ?? '',
            'price' => (float)$product->price,
            'unit' => $product->unit ?? 'sp',
            'category' => $product->category?->name ?? 'Chưa phân loại',
        ];

        // Dispatch job to sync to vector DB
        SyncProductToVectorDb::dispatch($product->id, 'upsert', $productData);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // Dispatch job to delete from vector DB
        SyncProductToVectorDb::dispatch($product->id, 'delete');
    }
}
