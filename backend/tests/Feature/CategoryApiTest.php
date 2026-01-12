<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_can_get_categories()
    {
        Category::create(['name' => 'Electronics', 'active' => true]);
        Category::create(['name' => 'Clothing', 'active' => true]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    
    public function test_only_returns_active_categories()
    {
        Category::create(['name' => 'Active Category', 'active' => true]);
        Category::create(['name' => 'Inactive Category', 'active' => false]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }
}