<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use Illuminate\Http\JsonResponse;

class ApiResponseService implements ApiResponseServiceInterface
{
    public function success(string $message, $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'type' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function error(string $message, $data = [], int $status = 400): JsonResponse
    {
        return response()->json([
            'type' => 'error',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function validationErrorResponse(array $errors, array $requestData): JsonResponse
    {
        $message = collect($errors)
            ->flatten()
            ->implode('; ');

        return response()->json([
            'type' => 'error',
            'message' => $message,
            'data' => $requestData,
        ], 422);
    }
}