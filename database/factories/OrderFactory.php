<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Nanti di-override seeder
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_price' => 0, // Nanti dihitung ulang
            'status' => 'completed', // Status selesai biar sah direview
            'shipping_address' => fake()->address(),
        ];
    }
}