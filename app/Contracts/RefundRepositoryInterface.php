<?php

namespace App\Contracts;

use App\Models\Refund;
use Illuminate\Database\Eloquent\Collection;

interface RefundRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Refund;
    public function create(array $data): Refund;
}