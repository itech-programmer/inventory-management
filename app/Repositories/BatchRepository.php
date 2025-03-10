<?php

namespace App\Repositories;

use App\Contracts\BatchRepositoryInterface;
use App\Models\Batch;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BatchRepository implements BatchRepositoryInterface
{
    public function updatePurchaseCost(int $batchId): bool
    {
        $totalCost = DB::table('batch_products')
            ->where('batch_id', $batchId)
            ->sum(DB::raw('quantity * price_at_purchase'));

        return Batch::where('id', $batchId)->update(['purchase_cost' => $totalCost]);
    }
}