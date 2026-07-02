<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['user_id', 'guest_token', 'sender', 'message'];

     /**
     * Tin nhắn thuộc về user (nếu đã đăng nhập)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check xem đây có phải tin nhắn của guest không
     */
    public function isGuest()
    {
        return $this->user_id === null && !empty($this->guest_token);
    }
}
