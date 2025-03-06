<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;
use App\DTO\OrderDto;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderService implements OrderServiceInterface
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAll(): JsonResponse
    {
        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $this->orderRepository->getAll()
        ], 200);
    }

    public function findById(int $id): JsonResponse
    {
        $order = $this->orderRepository->findById($id);

        return $order
            ? response()->json(['message' => 'Order found', 'data' => $order], 200)
            : response()->json(['message' => 'Order not found'], 404);
    }

    public function create(OrderDto $dto): JsonResponse
    {
        $order = Order::create(['client_id' => $dto->client_id]);

        foreach ($dto->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['qty']]);
        }

        return response()->json(['message' => 'Order created', 'data' => $order], 201);
    }

    public function delete(int $id): JsonResponse
    {
        return $this->orderRepository->delete($id)
            ? response()->json(['message' => 'Order deleted'], 200)
            : response()->json(['message' => 'Order not found'], 404);
    }
}
