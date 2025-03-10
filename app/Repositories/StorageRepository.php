<?php

namespace App\Repositories;

use App\Contracts\StorageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class StorageRepository implements StorageRepositoryInterface
{
    public function getRemainingQuantities(string $date): Collection
    {
        $result = DB::table('storage_products')
            ->join('products', 'storage_products.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(storage_products.quantity) as remaining_qty')
            )
            ->whereDate('storage_products.created_at', '<=', $date)
            ->groupBy('products.id', 'products.name')
            ->get();

        return new Collection($result);
    }
}
