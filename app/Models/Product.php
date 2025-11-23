<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationship: Product belongs to Store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Relationship: Product belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship: Product has many Cart items
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relationship: Product has many Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship: Product has many Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper: Get average rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Helper: Get total reviews count
    public function totalReviews()
    {
        return $this->reviews()->count();
    }
}