<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\RefundRepositoryInterface;
use App\Contracts\RefundServiceInterface;
use App\DTO\RefundDto;
use Illuminate\Http\JsonResponse;

class RefundService implements RefundServiceInterface
{
    private RefundRepositoryInterface $refundRepository;
    private ApiResponseServiceInterface $apiResponse;

    public function __construct(
        RefundRepositoryInterface $refundRepository,
        ApiResponseServiceInterface $apiResponse
    ) {
        $this->refundRepository = $refundRepository;
        $this->apiResponse = $apiResponse;
    }

    public function getAll(): JsonResponse
    {
        return $this->apiResponse->success('Refunds retrieved successfully', $this->refundRepository->getAll());
    }

    public function findById(int $id): JsonResponse
    {
        $refund = $this->refundRepository->findById($id);

        return $refund
            ? $this->apiResponse->success('Refund found', $refund)
            : $this->apiResponse->error('Refund not found', [], 404);
    }

    public function create(RefundDto $dto): JsonResponse
    {
        $refund = $this->refundRepository->create([
            'batch_id' => $dto->batch_id,
            'order_id' => $dto->order_id,
            'quantity' => $dto->quantity,
            'refund_amount' => $dto->refund_amount,
        ]);

        return $this->apiResponse->success('Refund processed', $refund, 201);
    }
}