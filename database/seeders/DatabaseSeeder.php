<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Approved Seller
        $seller1 = User::create([
            'name' => 'John Seller',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'approved',
        ]);

        // 3. Buat Pending Seller
        $seller2 = User::create([
            'name' => 'Jane Pending',
            'email' => 'pending@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'pending',
        ]);

        // 4. Buat Rejected Seller
        $seller3 = User::create([
            'name' => 'Bob Rejected',
            'email' => 'rejected@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'rejected',
        ]);

        // 5. Buat Buyers
        $buyer1 = User::create([
            'name' => 'Alice Buyer',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);

        $buyer2 = User::create([
            'name' => 'Charlie Customer',
            'email' => 'buyer2@example.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);

        // 6. Buat Categories
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Produk elektronik dan gadget'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Pakaian dan aksesoris'],
            ['name' => 'Buku', 'slug' => 'buku', 'description' => 'Buku dan majalah'],
            ['name' => 'Makanan', 'slug' => 'makanan', 'description' => 'Makanan dan minuman'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Peralatan olahraga'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // 7. Buat Store untuk Approved Seller
        $store1 = Store::create([
            'user_id' => $seller1->id,
            'name' => 'Tech Store',
            'slug' => 'tech-store',
            'description' => 'Toko elektronik terpercaya',
            'image' => 'stores/default-store.jpg',
        ]);

        // 8. Buat Products
        $products = [
            [
                'store_id' => $store1->id,
                'category_id' => 1, // Elektronik
                'name' => 'Laptop Gaming ASUS ROG',
                'slug' => 'laptop-gaming-asus-rog',
                'description' => 'Laptop gaming dengan spesifikasi tinggi untuk gaming dan editing',
                'price' => 15000000,
                'stock' => 10,
                'image' => 'products/laptop-asus.jpg',
            ],
            [
                'store_id' => $store1->id,
                'category_id' => 1,
                'name' => 'Mouse Gaming Logitech',
                'slug' => 'mouse-gaming-logitech',
                'description' => 'Mouse gaming dengan DPI tinggi dan RGB lighting',
                'price' => 500000,
                'stock' => 25,
                'image' => 'products/mouse-logitech.jpg',
            ],
            [
                'store_id' => $store1->id,
                'category_id' => 1,
                'name' => 'Keyboard Mechanical',
                'slug' => 'keyboard-mechanical',
                'description' => 'Keyboard mechanical dengan switch Cherry MX',
                'price' => 1200000,
                'stock' => 15,
                'image' => 'products/keyboard.jpg',
            ],
            [
                'store_id' => $store1->id,
                'category_id' => 2, // Fashion
                'name' => 'Kaos Polos Premium',
                'slug' => 'kaos-polos-premium',
                'description' => 'Kaos polos berbahan cotton combed 30s',
                'price' => 85000,
                'stock' => 100,
                'image' => 'products/kaos.jpg',
            ],
            [
                'store_id' => $store1->id,
                'category_id' => 3, // Buku
                'name' => 'Buku Pemrograman Laravel',
                'slug' => 'buku-pemrograman-laravel',
                'description' => 'Panduan lengkap belajar Laravel dari nol hingga mahir',
                'price' => 150000,
                'stock' => 50,
                'image' => 'products/buku-laravel.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✅ Database berhasil di-seed!');
        $this->command->info('');
        $this->command->info('📧 Akun Login:');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('Seller (Approved): seller@example.com / password');
        $this->command->info('Seller (Pending): pending@example.com / password');
        $this->command->info('Seller (Rejected): rejected@example.com / password');
        $this->command->info('Buyer: buyer@example.com / password');
    }
}