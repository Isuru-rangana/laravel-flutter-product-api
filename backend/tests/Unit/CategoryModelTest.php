<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_can_create_category()
    {
        $category = Category::create([
            'name' => 'Electronics',
            'active' => true
        ]);

        $this->assertEquals('Electronics', $category->name);
        $this->assertTrue($category->active);
    }

    
    public function test_has_correct_fillable_fields()
    {
        $category = new Category();
        $expected = ['name', 'active'];

        $this->assertEquals($expected, $category->getFillable());
    }
}