<?php

namespace App\Contracts;

interface BatchRepositoryInterface
{
    public function updatePurchaseCost(int $batchId): bool;
}