<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Storage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $provider = Provider::first();
        $product = Product::first();

        $batch = Batch::create([
            'provider_id' => $provider->id,
            'purchase_date' => now(),
            'purchase_cost' => 100 * 7.99
        ]);

        DB::table('batch_products')->insert([
            'batch_id' => $batch->id,
            'product_id' => $product->id,
            'quantity' => 100,
            'price_at_purchase' => 7.99
        ]);
    }
}
