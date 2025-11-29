<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Laptops, Smartphones, Tablets, and other electronic devices',
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming consoles, controllers, headsets, and accessories',
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Shoes, clothes, bags, and fashion accessories',
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Fiction, educational, and lifestyle books',
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Furniture, decor, and home essentials',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}