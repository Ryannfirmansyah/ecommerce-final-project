<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
        'shipping_address'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // Relasi: Order milik User (Buyer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Order punya banyak Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Order punya banyak Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper: Generate nomor order unik
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}