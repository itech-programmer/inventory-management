<?php

namespace App\Services;

use App\Contracts\RefundRepositoryInterface;
use App\Contracts\RefundServiceInterface;
use Illuminate\Http\JsonResponse;

class RefundService implements RefundServiceInterface
{
    private RefundRepositoryInterface $refundRepository;

    public function __construct(RefundRepositoryInterface $refundRepository)
    {
        $this->refundRepository = $refundRepository;
    }

    public function getAll(): JsonResponse
    {
        return response()->json([
            'message' => 'Refunds retrieved successfully',
            'data' => $this->refundRepository->getAll()
        ], 200);
    }

    public function findById(int $id): JsonResponse
    {
        $refund = $this->refundRepository->findById($id);

        return $refund
            ? response()->json(['message' => 'Refund found', 'data' => $refund], 200)
            : response()->json(['message' => 'Refund not found'], 404);
    }

    public function create(RefundDto $dto): JsonResponse
    {
        $refund = $this->refundRepository->create([
            'batch_id' => $dto->batch_id,
            'order_id' => $dto->order_id,
            'quantity' => $dto->quantity,
            'refund_amount' => $dto->refund_amount,
        ]);

        return response()->json(['message' => 'Refund processed', 'data' => $refund], 201);
    }
}