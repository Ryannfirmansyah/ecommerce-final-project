<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Laptops, Smartphones, Tablets, and other electronic devices'
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming consoles, controllers, headsets, and accessories'
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Shoes, clothes, bags, and fashion accessories'
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Fiction, educational, and lifestyle books'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}