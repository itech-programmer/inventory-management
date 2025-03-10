<?php

namespace App\Contracts;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Collection;

interface BatchRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Batch;
    public function create(array $data): Batch;
    public function updatePurchaseCost(int $batchId): bool;
    public function purchaseProduct(int $batchId, int $productId, int $quantity, float $priceAtPurchase): bool;
}