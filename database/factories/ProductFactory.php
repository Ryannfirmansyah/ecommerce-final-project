<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true); // Nama produk 3 kata
        return [
            // Store dan Category akan kita set saat dipanggil di Seeder
            'store_id' => Store::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'name' => ucwords($name),
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(50000, 5000000), // Harga 50rb - 5jt
            'stock' => fake()->numberBetween(1, 100),
            'image' => 'products/default.jpg', // Pastikan ada gambar dummy
        ];
    }
}