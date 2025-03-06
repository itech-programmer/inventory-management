<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\RefundServiceInterface;
use App\DTO\RefundDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\RefundRequest;
use Illuminate\Http\JsonResponse;

class RefundController extends Controller
{
    private RefundServiceInterface $refundService;

    public function __construct(RefundServiceInterface $refundService)
    {
        $this->refundService = $refundService;
    }

    public function index(): JsonResponse
    {
        return $this->refundService->getAll();
    }

    public function show(int $id): JsonResponse
    {
        return $this->refundService->findById($id);
    }

    public function store(RefundRequest $request): JsonResponse
    {
        $dto = new RefundDto(
            $request->validated()['batch_id'] ?? null,
            $request->validated()['order_id'] ?? null,
            $request->validated()['quantity'],
            $request->validated()['refund_amount']
        );

        return $this->refundService->create($dto);
    }
}