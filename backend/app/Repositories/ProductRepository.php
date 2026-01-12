<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
   
    public function create(array $data): Product
    {
        return Product::create([
            'name'        => $data['name'],
            'category_id' => $data['category_id'],
            'price'       => $data['price'],
            'active'      => $data['active']
        ]);
    }

   
    public function getAllWithCategory(): Collection
    {
        return Product::with('category')->get();
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }
}