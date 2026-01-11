<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    
    public function index(): JsonResponse
    {
        try {
            $products = $this->productService->getAllProducts();
            
            return ApiResponse::success(
                ProductResource::collection($products),
                'Products retrieved successfully'
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                'Failed to retrieve products',
                null,
                500
            );
        }
    }

   
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            
            $product = $this->productService->createProduct($validatedData);
            
            return ApiResponse::success(
                new ProductResource($product),
                'Product created successfully',
                201
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                'Failed to create product: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->findProductById($id);
            
            if (!$product) {
                return ApiResponse::notFound('Product not found');
            }
            
            return ApiResponse::success(
                new ProductResource($product),
                'Product retrieved successfully'
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                'Failed to retrieve product',
                null,
                500
            );
        }
    }
}