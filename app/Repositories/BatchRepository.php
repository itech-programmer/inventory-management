<?php

namespace App\Repositories;

use App\Contracts\BatchRepositoryInterface;
use App\Models\Batch;
use Illuminate\Database\Eloquent\Collection;

class BatchRepository implements BatchRepositoryInterface
{
    public function getAll(): Collection
    {
        return Batch::all();
    }

    public function findById(int $id): ?Batch
    {
        return Batch::find($id);
    }

    public function create(array $data): Batch
    {
        return Batch::create($data);
    }
}