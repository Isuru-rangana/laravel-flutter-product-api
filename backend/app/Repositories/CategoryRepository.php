<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
   
    public function getActiveCategories(): Collection
    {
        return Category::where('active', true)
            ->orderBy('name', 'asc')
            ->get();
    }

    
    public function findById(int $id): ?Category
    {
        return Category::find($id);
    }
}