<?php

namespace App\Contracts;

use App\DTO\ProductDto;
use Illuminate\Http\JsonResponse;

interface ProductServiceInterface
{
    public function getAll(): JsonResponse;
    public function findById(int $id): JsonResponse;
    public function create(ProductDto $dto): JsonResponse;
    public function update(int $id, ProductDto $dto): JsonResponse;
    public function delete(int $id): JsonResponse;
}