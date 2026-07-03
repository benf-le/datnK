<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'subtotal',
        'discount_amount',
        'shipping_fee',
        'total_price',
        'status',
        'note',
        'shipping_full_name',
        'shipping_phone',
        'shipping_address',
        'shipping_ward',
        'shipping_district',
        'shipping_city',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function orderStatusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function getShippingAddressAttribute()
    {
        $rawAddress = $this->attributes['shipping_address'] ?? null;
        if (!$rawAddress && !$this->shipping_full_name) {
            return null;
        }
        return (object) [
            'full_name' => $this->shipping_full_name,
            'phone' => $this->shipping_phone,
            'address' => $rawAddress,
            'ward' => $this->shipping_ward,
            'district' => $this->shipping_district,
            'city' => $this->shipping_city,
        ];
    }
}
