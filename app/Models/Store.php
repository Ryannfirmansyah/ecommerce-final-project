<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'image'
    ];

    // Relationship: Store belongs to User (Seller)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Store has many Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}