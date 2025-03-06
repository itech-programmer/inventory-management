<?php

namespace App\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Order;
    public function create(array $data): Order;
    public function delete(int $id): bool;
}