<?php

namespace App\Contracts;

use App\DTO\OrderDto;
use Illuminate\Http\JsonResponse;

interface OrderServiceInterface
{
    public function getAll(): JsonResponse;
    public function getByClientId(int $clientId): JsonResponse;
    public function findById(int $id): JsonResponse;
    public function create(OrderDto $dto): JsonResponse;
    public function delete(int $id): JsonResponse;
}