<?php

namespace App\Services;

use App\Contracts\BatchProfitServiceInterface;
use App\Models\Batch;
use Illuminate\Http\JsonResponse;

class BatchProfitService implements BatchProfitServiceInterface
{
    public function calculateProfit(): JsonResponse
    {
        $batches = Batch::with(['products', 'refunds'])->get();

        $profits = $batches->map(function ($batch) {
            $totalSales = $batch->products->sum(function ($product) {
                return $product->price * $product->pivot->quantity;
            });

            $totalRefunds = $batch->refunds->sum('refund_amount');

            $profit = $totalSales - $totalRefunds;

            return [
                'batch_id' => $batch->id,
                'total_sales' => $totalSales,
                'total_refunds' => $totalRefunds,
                'profit' => $profit
            ];
        });

        return response()->json([
            'message' => 'Batch profit calculated successfully',
            'data' => $profits
        ], 200);
    }
}