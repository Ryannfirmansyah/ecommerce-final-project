<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

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