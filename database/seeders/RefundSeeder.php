<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Refund;
use Illuminate\Database\Seeder;

class RefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::first();

        Refund::create([
            'order_id' => $order->id,
            'quantity' => 1,
            'refund_amount' => 5.50
        ]);
    }
}
