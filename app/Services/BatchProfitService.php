<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\BatchProfitServiceInterface;
use App\Models\Batch;
use Illuminate\Http\JsonResponse;

class BatchProfitService implements BatchProfitServiceInterface
{
    private ApiResponseServiceInterface $apiResponse;

    public function __construct(ApiResponseServiceInterface $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function calculateProfit(): JsonResponse
    {
        $batches = Batch::with(['products', 'refunds'])->get();

        if ($batches->isEmpty()) {
            return $this->apiResponse->error('No batch data found', [], 404);
        }

        $profits = $batches->map(function ($batch) {
            $totalSales = $batch->products->sum(function ($product) {
                return $product->pivot->price_at_sale * $product->pivot->quantity;
            });

            $totalRefunds = $batch->refunds->sum('refund_amount');

            $totalCost = $batch->products->sum(function ($product) {
                return $product->pivot->price_at_purchase * $product->pivot->quantity;
            });

            return [
                'batch_id' => $batch->id,
                'total_sales' => $totalSales,
                'total_cost' => $totalCost,
                'total_refunds' => $totalRefunds,
                'profit' => $totalSales - $totalRefunds - $totalCost
            ];
        });

        return $this->apiResponse->success('Batch profit calculated successfully', $profits);
    }
}