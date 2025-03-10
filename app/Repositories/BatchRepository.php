<?php

namespace App\Repositories;

use App\Contracts\BatchRepositoryInterface;
use App\Models\Batch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BatchRepository implements BatchRepositoryInterface
{
    public function getAll(): Collection
    {
        return Batch::all();
    }

    public function findById(int $id): ?Batch
    {
        return Batch::find($id);
    }

    public function create(array $data): Batch
    {
        return Batch::create($data);
    }

    public function updatePurchaseCost(int $batchId): bool
    {
        try {
            $totalCost = DB::table('batch_products')
                ->where('batch_id', $batchId)
                ->sum(DB::raw('quantity * price_at_purchase'));

            return Batch::where('id', $batchId)->update(['purchase_cost' => $totalCost]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function purchaseProduct(int $batchId, int $productId, int $quantity, float $priceAtPurchase): bool
    {
        try {
            DB::beginTransaction();

            DB::table('batch_products')->insert([
                'batch_id' => $batchId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price_at_purchase' => $priceAtPurchase
            ]);

            DB::table('storage_products')->insert([
                'storage_id' => 1,
                'product_id' => $productId,
                'batch_id' => $batchId,
                'quantity' => $quantity,
                'price_at_purchase' => $priceAtPurchase
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}