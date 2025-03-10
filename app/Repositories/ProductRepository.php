<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        return Product::with('category:id,name')->get(['id', 'name', 'category_id', 'price']);
    }

    public function getAvailableProducts(): Collection
    {
        return Product::query()
            ->join('storage_products', 'storage_products.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select([
                'products.id',
                'products.name',
                'categories.name as category_name',
                'products.price',
                DB::raw('SUM(storage_products.quantity) as qty')
            ])
            ->groupBy('products.id', 'products.name', 'categories.name', 'products.price')
            ->having('qty', '>', 0)
            ->get()
            ->map(function ($product) {
                $product->qty = (int) $product->qty;
                $product->price = (float) $product->price;
                return $product;
            });
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): ?Product
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($data);
        }
        return $product;
    }

    public function delete(int $id): bool
    {
        return Product::destroy($id) > 0;
    }
}