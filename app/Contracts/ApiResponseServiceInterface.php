<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface ApiResponseServiceInterface
{
    public function success(string $message, $data = [], int $status = 200): JsonResponse;

    public function error(string $message, $data = [], int $status = 400): JsonResponse;

    public function validationErrorResponse(array $errors, array $requestData): JsonResponse;
}