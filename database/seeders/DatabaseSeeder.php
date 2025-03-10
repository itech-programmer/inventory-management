<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProviderSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            BatchSeeder::class,
            StorageSeeder::class,
            ClientSeeder::class,
            OrderSeeder::class,
            RefundSeeder::class,
        ]);
    }
}
