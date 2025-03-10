<?php

namespace App\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Category;
    public function getSubcategories(int $categoryId): Collection;
    public function getByProvider(int $providerId): Collection;
    public function create(array $data): Category;
    public function update(int $id, array $data): ?Category;
    public function delete(int $id): bool;
}
