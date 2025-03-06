<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface BatchProfitServiceInterface
{
    public function calculateProfit(): JsonResponse;

}