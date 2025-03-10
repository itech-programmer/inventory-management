<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface StorageServiceInterface
{
    public function getRemainingQuantities(string $date): JsonResponse;
}
