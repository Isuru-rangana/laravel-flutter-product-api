<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    
    public function getActiveCategoriesForDropdown(): Collection
    {
        return $this->categoryRepository->getActiveCategories();
    }

    public function findCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    /**
     * Check if a category exists 
     */
    public function isCategoryActiveAndExists(int $categoryId): bool
    {
        $category = $this->findCategoryById($categoryId);
        
        return $category && $category->active;
    }
}