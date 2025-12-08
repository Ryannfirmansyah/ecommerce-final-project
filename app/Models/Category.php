<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image'
    ];

    // Relationship: Category has many Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relasi "Has Many Through" untuk menghitung total item terjual per kategori
    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Product::class);
    }
}