<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\BatchProfitServiceInterface;
use App\Contracts\BatchRepositoryInterface;
use App\DTO\PurchaseProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseProductRequest;
use Illuminate\Http\JsonResponse;

class BatchController extends Controller
{
    private BatchProfitServiceInterface $batchProfitService;

    public function __construct(
        BatchProfitServiceInterface $batchProfitService,
    ) {
        $this->batchProfitService = $batchProfitService;
    }

    public function calculateProfit(): JsonResponse
    {
        return $this->batchProfitService->calculateProfit();
    }
}
