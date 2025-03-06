<?php

namespace App\Contracts;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Collection;

interface BatchRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Batch;
    public function create(array $data): Batch;
}