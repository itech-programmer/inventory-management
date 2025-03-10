<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\BatchProfitServiceInterface;
use App\Models\Batch;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BatchProfitService implements BatchProfitServiceInterface
{
    private ApiResponseServiceInterface $apiResponse;

    public function __construct(
        ApiResponseServiceInterface $apiResponse
    ) {
        $this->apiResponse = $apiResponse;
    }

    public function calculateProfit(): JsonResponse
    {
        $batches = Batch::with(['products', 'refunds'])->get();

        if ($batches->isEmpty()) {
            return $this->apiResponse->error('No batch data found', [], 404);
        }

        $profits = $batches->map(function ($batch) {
            $totalSales = DB::table('order_products')
                ->where('batch_id', $batch->id)
                ->sum(DB::raw('quantity * price_at_sale'));

            $totalRefunds = $batch->refunds->sum('refund_amount');

            $totalCost = DB::table('batch_products')
                ->where('batch_id', $batch->id)
                ->sum(DB::raw('quantity * price_at_purchase'));

            return [
                'batch_id' => $batch->id,
                'total_sales' => (float) $totalSales,
                'total_cost' => (float) $totalCost,
                'total_refunds' => (float) $totalRefunds,
                'profit' => (float) ($totalSales - $totalRefunds - $totalCost)
            ];
        });

        return $this->apiResponse->success('Batch profit calculated successfully', $profits);
    }
}