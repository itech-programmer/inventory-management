<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface CategoryServiceInterface
{
    public function getAll(): JsonResponse;
    public function findById(int $id): JsonResponse;
    public function getSubcategories(int $categoryId): JsonResponse;
    public function getByProvider(int $providerId): JsonResponse;
    public function create(array $data): JsonResponse;
    public function update(int $id, array $data): JsonResponse;
    public function delete(int $id): JsonResponse;
}
