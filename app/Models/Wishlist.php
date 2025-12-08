<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // Relasi untuk mengambil data Produk (nama, harga, gambar)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke User (opsional, jarang dipakai dari sisi ini)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}