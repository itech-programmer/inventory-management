<?php

namespace App\Repositories;

use App\Contracts\RefundRepositoryInterface;
use App\Models\Refund;
use Illuminate\Database\Eloquent\Collection;

class RefundRepository implements RefundRepositoryInterface
{
    public function getAll(): Collection
    {
        return Refund::all();
    }

    public function findById(int $id): ?Refund
    {
        return Refund::find($id);
    }

    public function create(array $data): Refund
    {
        return Refund::create($data);
    }
}