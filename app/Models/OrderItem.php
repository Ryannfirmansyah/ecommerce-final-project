<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function userReview()
    {
        return $this->hasOne(Review::class, 'product_id', 'product_id')
                    ->where('order_id', $this->order_id)
                    ->where('user_id', Auth::id());
    }

    // Relasi: OrderItem milik Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: OrderItem milik Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper: Hitung subtotal item ini
    public function subtotal()
    {
        return $this->quantity * $this->price;
    }
}