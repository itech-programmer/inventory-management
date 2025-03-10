<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\BatchProfitServiceInterface;
use App\Contracts\BatchRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseProductRequest;
use Illuminate\Http\JsonResponse;

class BatchController extends Controller
{
    private BatchProfitServiceInterface $batchProfitService;
    private BatchRepositoryInterface $batchRepository;

    public function __construct(
        BatchProfitServiceInterface $batchProfitService,
        BatchRepositoryInterface $batchRepository
    ) {
        $this->batchProfitService = $batchProfitService;
        $this->batchRepository = $batchRepository;
    }

    public function calculateProfit(): JsonResponse
    {
        return response()->json([
            'message' => 'Batch profit calculated successfully',
            'data' => $this->batchProfitService->calculateProfit()
        ]);
    }

    public function purchaseProduct(PurchaseProductRequest $request): JsonResponse
    {
        $success = $this->batchRepository->purchaseProduct(
            $request->validated()['batch_id'],
            $request->validated()['product_id'],
            $request->validated()['quantity'],
            $request->validated()['price_at_purchase']
        );

        return $success
            ? response()->json(['message' => 'Product purchased and added to storage'], 201)
            : response()->json(['message' => 'Purchase failed'], 500);
    }
}
