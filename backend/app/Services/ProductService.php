<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    /**
     * Create a new product with validation.
     * This handles the main business logic for product creation as required by the assignment.
     * 
     * @param array $data Validated data containing name, category_id, price, active
     * @return Product
     * @throws ValidationException
     */
    public function createProduct(array $data): Product
    {
        // Verify that the category exists and is active
        $category = $this->categoryRepository->findById($data['category_id']);
        
        if (!$category) {
            throw ValidationException::withMessages([
                'category_id' => ['The selected category does not exist.']
            ]);
        }
        
        if (!$category->active) {
            throw ValidationException::withMessages([
                'category_id' => ['The selected category is not active.']
            ]);
        }

        // Create the product using repository
        return $this->productRepository->create($data);
    }

    /**
     * Get all products with their categories.
     * Useful for displaying products list or verification.
     */
    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAllWithCategory();
    }

    /**
     * Find a specific product by ID.
     */
    public function findProductById(int $id): ?Product
    {
        return $this->productRepository->findById($id);
    }
}