<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Storage;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = Client::first();
        $product = Product::first();
        $storage = Storage::first();
        $batch = Batch::whereHas('products', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->orderBy('purchase_date', 'asc')->first();

        $order = Order::create(['client_id' => $client->id]);

        $order->products()->attach($product->id, [
            'batch_id' => $batch->id,
            'storage_id' => $storage->id,
            'quantity' => 2,
            'price_at_sale' => 12.99
        ]);
    }
}
