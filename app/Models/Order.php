<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'name',
        'email',
        'order_type',
        'delivery_address',
        'notes',
        'total_price',
        'status',
        'token',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->token)) {
                $order->token = Str::random(32);
            }
        });
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
