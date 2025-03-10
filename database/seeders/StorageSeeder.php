<?php

namespace Database\Seeders;

use App\Models\BatchProduct;
use App\Models\Product;
use App\Models\Storage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storage = Storage::create(['location' => 'Main Warehouse']);
        $product = Product::first();
        $batchProduct = BatchProduct::where('product_id', $product->id)->first();

        DB::table('storage_products')->insert([
            'storage_id' => $storage->id,
            'product_id' => $product->id,
            'batch_id' => $batchProduct->batch_id,
            'quantity' => 50,
            'price_at_purchase' => 7.99
        ]);
    }
}
