<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     use HasFactory;

    protected $fillable = ['name', 'slug', 'category_id', 'description', 'price', 'stock', 'status', 'unit', 'thumbnail'];

    protected $appends = ['image_url', 'average_rating'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function firstImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true)->orderBy('sort_order', 'ASC');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->firstImage?->image_path
            ? asset('storage/' . $this->firstImage->image_path)
            : asset('storage/uploads/products/product-default.png');
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews->avg('rating') ?? 0;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
