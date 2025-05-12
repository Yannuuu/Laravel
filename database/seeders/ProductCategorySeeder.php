<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics' => 'Electronic devices and accessories',
            'Fashion' => 'Clothing, shoes, and accessories',
            'Home & Living' => 'Furniture and home decor',
            'Books' => 'Books and digital content',
            'Sports' => 'Sports equipment and accessories'
        ];

        foreach ($categories as $name => $description) {
            ProductCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description,
                'is_active' => true
            ]);
        }
    }
}
