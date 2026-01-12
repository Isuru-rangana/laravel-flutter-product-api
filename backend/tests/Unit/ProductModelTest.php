<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_can_create_product()
    {
        $category = Category::create(['name' => 'Electronics', 'active' => true]);
        
        $product = Product::create([
            'name' => 'iPhone',
            'price' => 999.99,
            'category_id' => $category->id,
            'active' => true
        ]);

        $this->assertEquals('iPhone', $product->name);
        $this->assertEquals(999.99, $product->price);
    }

   
    public function test_belongs_to_category()
    {
        $category = Category::create(['name' => 'Electronics', 'active' => true]);
        $product = Product::create([
            'name' => 'iPhone',
            'price' => 999.99,
            'category_id' => $category->id,
            'active' => true
        ]);

        $this->assertEquals($category->name, $product->category->name);
    }

    
    public function test_has_correct_fillable_fields()
    {
        $product = new Product();
        $expected = ['name', 'category_id', 'price', 'active'];

        $this->assertEquals($expected, $product->getFillable());
    }
}