<?php

namespace App\Contracts;

use App\DTO\RefundDto;
use Illuminate\Http\JsonResponse;

interface RefundServiceInterface
{
    public function getAll(): JsonResponse;
    public function findById(int $id): JsonResponse;
    public function create(RefundDto $dto): JsonResponse;
}