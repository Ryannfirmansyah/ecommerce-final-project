<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'seller_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Relasi: User punya satu Store (jika role = seller)
    public function store()
    {
        return $this->hasOne(Store::class);
    }

    // Relasi: User punya banyak Cart items
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi: User punya banyak Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi: User punya banyak Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper: Cek apakah user adalah Admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper: Cek apakah user adalah Seller
    public function isSeller()
    {
        return $this->role === 'seller';
    }

    // Helper: Cek apakah user adalah Buyer
    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    // Helper: Cek apakah Seller sudah disetujui
    public function isApprovedSeller()
    {
        return $this->role === 'seller' && $this->seller_status === 'approved';
    }

    // Helper: Cek apakah Seller masih pending
    public function isPendingSeller()
    {
        return $this->role === 'seller' && $this->seller_status === 'pending';
    }

    // Helper: Cek apakah Seller ditolak
    public function isRejectedSeller()
    {
        return $this->role === 'seller' && $this->seller_status === 'rejected';
    }

}
