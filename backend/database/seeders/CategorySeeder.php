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
            ['name' => 'Electronics', 'active' => true],
            ['name' => 'Clothing', 'active' => true],
            ['name' => 'Home & Garden', 'active' => true],
            ['name' => 'Sports', 'active' => true],
            ['name' => 'Books', 'active' => false], 
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
