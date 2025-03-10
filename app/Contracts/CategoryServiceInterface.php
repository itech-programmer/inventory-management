<?php

namespace App\Contracts;

use App\DTO\CategoryDto;
use Illuminate\Http\JsonResponse;

interface CategoryServiceInterface
{
    public function getAll(): JsonResponse;
    public function findById(int $id): JsonResponse;
    public function getSubcategories(int $categoryId): JsonResponse;
    public function getByProvider(int $providerId): JsonResponse;
    public function create(CategoryDto $dto): JsonResponse;
    public function update(int $id, CategoryDto $dto): JsonResponse;
    public function delete(int $id): JsonResponse;
}
