<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
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

    public function scopeForStore(Builder $query, $storeId)
    {
        return $query->whereHas('orderItems.product', function ($q) use ($storeId) {
                $q->where('store_id', $storeId);
            })
            ->with(['user', 'orderItems' => function ($q) use ($storeId) {
                // Filter eager load: hanya item milik toko ini yang ditarik dari DB
                $q->whereHas('product', function ($p) use ($storeId) {
                    $p->where('store_id', $storeId);
                })->with('product');
            }]);
    }

    protected function storeTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->orderItems->sum(function ($item) {
                return $item->price * $item->quantity;
            }),
        );
    }

    // Virtual Attribute: $order->store_items_count
    protected function storeItemsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->orderItems->sum('quantity'),
        );
    }

    public function getStatusAttribute()
    {
        // Ambil semua status item dalam order ini
        $itemStatuses = $this->orderItems->pluck('status');

        // 1. Jika semua item 'completed' -> Order Selesai
        if ($itemStatuses->every(fn($s) => $s === 'completed')) {
            return 'completed';
        }

        // 2. Jika semua item 'cancelled' -> Order Dibatalkan
        if ($itemStatuses->every(fn($s) => $s === 'cancelled')) {
            return 'cancelled';
        }

        // 3. Jika ada minimal satu yang 'processing' -> Order Sedang Proses
        if ($itemStatuses->contains('processing')) {
            return 'processing';
        }

        // 4. Jika ada yang completed tapi belum semua -> Order Sedang Proses (Partial)
        if ($itemStatuses->contains('completed')) {
            return 'processing';
        }

        // Default: Pending
        return 'pending';
    }
}