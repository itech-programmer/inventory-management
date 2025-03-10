<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\OrderServiceInterface;
use App\DTO\OrderDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        return $this->orderService->getAll();
    }

    public function show(int $id): JsonResponse
    {
        return $this->orderService->findById($id);
    }

    public function getByClient(int $clientId): JsonResponse
    {
        return $this->orderService->getByClientId($clientId);
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $dto = new OrderDto(
            $request->validated()['client_id'],
            $request->validated()['products']
        );

        return $this->orderService->create($dto);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->orderService->delete($id);
    }
}