<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\BatchProduct;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAll(): Collection
    {
        return Order::with(['products', 'client:id,name'])->get();
    }

    public function getByClientId(int $clientId): Collection
    {
        return Order::where('client_id', $clientId)->with('products')->get();
    }

    public function assignBatchToOrder(int $orderId, int $productId, int $quantity): bool
    {
        try {
            DB::beginTransaction();

            $batches = BatchProduct::where('product_id', $productId)
                ->where('quantity', '>', 0)
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($batches as $batch) {
                if ($quantity <= 0) break;

                $batchQuantity = $batch->quantity;
                $assignedQuantity = min($batchQuantity, $quantity);

                // Привязываем товар к заказу
                DB::table('order_products')->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'batch_id' => $batch->batch_id,
                    'quantity' => $assignedQuantity,
                    'price_at_sale' => DB::table('products')->where('id', $productId)->value('price'),
                    'sold_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Уменьшаем количество в партии
                $batch->quantity -= $assignedQuantity;
                $batch->save();

                // Уменьшаем количество в `storage_products`
                DB::table('storage_products')
                    ->where('product_id', $productId)
                    ->where('batch_id', $batch->batch_id)
                    ->where('quantity', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit(1)
                    ->decrement('quantity', $assignedQuantity);

                $quantity -= $assignedQuantity;
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function findById(int $id): ?Order
    {
        return Order::with('products')->find($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function delete(int $id): bool
    {
        return Order::destroy($id) > 0;
    }
}