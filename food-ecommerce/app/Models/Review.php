<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItem;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the reviewer has purchased the product
     */
    public function hasPurchased()
    {
        return OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', $this->user_id)->where('status', 'completed');
        })->where('product_id', $this->product_id)->exists();
    }
}

