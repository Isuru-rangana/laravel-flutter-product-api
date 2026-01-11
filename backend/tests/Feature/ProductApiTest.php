<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->category = Category::create([
            'name' => 'Electronics',
            'active' => true
        ]);
        
        $this->inactiveCategory = Category::create([
            'name' => 'Inactive Category',
            'active' => false
        ]);
    }

   
    public function test_can_get_active_categories()
    {
        $response = $this->getJson('/api/categories');
        
        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data')));
    }

   
    public function test_can_create_a_product()
    {
        $productData = [
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'active' => true
        ];

        $response = $this->postJson('/api/products', $productData);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99
        ]);
    }

    
    public function test_validates_required_fields()
    {
        $response = $this->postJson('/api/products', []);
        
        $response->assertStatus(422);
    }

    
    public function test_validates_category_exists()
    {
        $productData = [
            'name' => 'Test Product',
            'category_id' => 999,
            'price' => 99.99,
            'active' => true
        ];

        $response = $this->postJson('/api/products', $productData);
        
        $response->assertStatus(422);
    }

    
    public function test_can_get_all_products()
    {
        Product::create([
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'active' => true
        ]);

        $response = $this->getJson('/api/products');
        
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_can_show_single_product()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'active' => true
        ]);

        $response = $this->getJson("/api/products/{$product->id}");
        
        $response->assertStatus(200);
        $this->assertEquals('Test Product', $response->json('data.name'));
    }
}