<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Exception;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}


    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoryService->getActiveCategoriesForDropdown();
            
            return ApiResponse::success(
                CategoryResource::collection($categories),
                'Active categories retrieved successfully'
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                'Failed to retrieve categories',
                null,
                500
            );
        }
    }

    
    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->categoryService->findCategoryById($id);
            
            if (!$category) {
                return ApiResponse::notFound('Category not found');
            }
            
            return ApiResponse::success(
                new CategoryResource($category),
                'Category retrieved successfully'
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                'Failed to retrieve category',
                null,
                500
            );
        }
    }
}