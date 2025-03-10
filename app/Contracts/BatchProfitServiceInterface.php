<?php

namespace App\Contracts;

use App\DTO\PurchaseProductDto;
use Illuminate\Http\JsonResponse;

interface BatchProfitServiceInterface
{
    public function calculateProfit(): JsonResponse;
}