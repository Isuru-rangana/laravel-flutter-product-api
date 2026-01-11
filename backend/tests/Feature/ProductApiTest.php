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
        
        // Create test categories
        $this->category = Category::create([
            'name' => 'Electronics',
            'active' => true
        ]);
        
        $this->inactiveCategory = Category::create([
            'name' => 'Inactive Category',
            'active' => false
        ]);
    }

    /** @test */
    public function it_can_get_active_categories()
    {
        $response = $this->getJson('/api/categories');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         '*' => ['id', 'name', 'active', 'created_at', 'updated_at']
                     ]
                 ]);
                 
        // Should only return active categories
        $this->assertEquals(1, count($response->json('data')));
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $productData = [
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'active' => true
        ];

        $response = $this->postJson('/api/products', $productData);
        
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'success',
                     'message', 
                     'data' => [
                         'id', 'name', 'price', 'active', 'category_id', 
                         'category' => ['id', 'name', 'active'],
                         'created_at', 'updated_at'
                     ]
                 ]);
                 
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99,
            'category_id' => $this->category->id
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/products', []);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'category_id', 'price', 'active']);
    }

    /** @test */
    public function it_validates_category_exists()
    {
        $productData = [
            'name' => 'Test Product',
            'category_id' => 999, // Non-existent category
            'price' => 99.99,
            'active' => true
        ];

        $response = $this->postJson('/api/products', $productData);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['category_id']);
    }

    /** @test */
    public function it_can_get_all_products()
    {
        // Create test product
        Product::create([
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'active' => true
        ]);

        $response = $this->getJson('/api/products');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         '*' => [
                             'id', 'name', 'price', 'active', 'category_id',
                             'category' => ['id', 'name', 'active'],
                             'created_at', 'updated_at'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function it_can_show_single_product()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'active' => true
        ]);

        $response = $this->getJson("/api/products/{$product->id}");
        
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $product->id,
                         'name' => 'Test Product',
                         'price' => 99.99
                     ]
                 ]);
    }
}