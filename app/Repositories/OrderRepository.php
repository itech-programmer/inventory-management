<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAll(): Collection
    {
        return Order::all();
    }

    public function findById(int $id): ?Order
    {
        return Order::with('products')->find($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function delete(int $id): bool
    {
        return Order::destroy($id) > 0;
    }
}