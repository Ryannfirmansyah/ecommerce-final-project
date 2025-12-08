<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Seller (Pemilik Tech Store)
        User::create([
            'name' => 'John Seller',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'approved',
        ]);

        // 3. Pending Seller
        User::create([
            'name' => 'Jane Pending',
            'email' => 'pending@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'pending',
        ]);

        // 4. Rejected Seller
        User::create([
            'name' => 'Bob Rejected',
            'email' => 'rejected@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'rejected',
        ]);

        // 5. Buyer
        User::create([
            'name' => 'Alice Buyer',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);
    }
}