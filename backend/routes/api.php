<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);    // Get active categories
    Route::get('/{id}', [CategoryController::class, 'show']); // Get single category
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);     // Get all products
    Route::post('/', [ProductController::class, 'store']);    // Create product (main endpoint)
    Route::get('/{id}', [ProductController::class, 'show']); // Get single product
});