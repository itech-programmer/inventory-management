<?php

namespace App\Services;

use App\Contracts\ApiResponseServiceInterface;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;
use App\DTO\OrderDto;
use App\Models\BatchProduct;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    private OrderRepositoryInterface $orderRepository;
    private ApiResponseServiceInterface $apiResponse;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ApiResponseServiceInterface $apiResponse
    ) {
        $this->orderRepository = $orderRepository;
        $this->apiResponse = $apiResponse;
    }

    public function getAll(): JsonResponse
    {
        $orders = $this->orderRepository->getAll()->load('products');

        return $this->apiResponse->success('Orders retrieved successfully', $orders);
    }

    public function getByClientId(int $clientId): JsonResponse
    {
        $orders = $this->orderRepository->getByClientId($clientId);

        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $orders
        ], 200);
    }

    public function findById(int $id): JsonResponse
    {
        $order = $this->orderRepository->findById($id);

        return $order
            ? $this->apiResponse->success('Order found', $order)
            : $this->apiResponse->error('Order not found', [], 404);
    }

    public function create(OrderDto $dto): JsonResponse
    {
            DB::beginTransaction();

            $order = $this->orderRepository->create(['client_id' => $dto->client_id]);

            $orderedProducts = [];

            foreach ($dto->products as $product) {
                $price = $product['price'] ?? DB::table('products')->where('id', $product['id'])->value('price');

                if (!$price) {
                    DB::rollBack();
                    return $this->apiResponse->error("Price not found for product ID: {$product['id']}", [], 422);
                }

                $quantityRequired = $product['qty'];

                $batches = BatchProduct::where('product_id', $product['id'])
                    ->where('quantity', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();

                foreach ($batches as $batch) {
                    if ($quantityRequired <= 0) break;

                    $batchQuantity = $batch->quantity;
                    $assignedQuantity = min($batchQuantity, $quantityRequired);

                    $storageId = DB::table('storage_products')
                        ->where('product_id', $product['id'])
                        ->where('batch_id', $batch->batch_id)
                        ->value('storage_id');

                    if (!$storageId) {
                        return $this->apiResponse->error("Storage not found for product ID: {$product['id']}", [], 422);
                    }

                    OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $product['id'],
                        'batch_id' => $batch->batch_id,
                        'storage_id' => $storageId,
                        'quantity' => $assignedQuantity,
                        'price_at_sale' => $price
                    ]);

                    $batch->quantity -= $assignedQuantity;
                    $batch->save();

                    $quantityRequired -= $assignedQuantity;

                    $orderedProducts[] = [
                        'id' => $product['id'],
                        'name' => DB::table('products')->where('id', $product['id'])->value('name'),
                        'quantity' => $assignedQuantity,
                        'price_at_sale' => (float) $price,
                        'batch_id' => $batch->batch_id
                    ];
                }
            }

            DB::commit();

            return $this->apiResponse->success('Order created successfully', [
                'order' => $order,
                'products' => $orderedProducts
            ], 201);
    }

    public function delete(int $id): JsonResponse
    {
        return $this->orderRepository->delete($id)
            ? $this->apiResponse->success('Order deleted successfully')
            : $this->apiResponse->error('Order not found', [], 404);
    }
}
