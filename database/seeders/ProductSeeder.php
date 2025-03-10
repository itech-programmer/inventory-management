<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blackTeaCategory = Category::where('name', 'Black Tea')->first();

        Product::create([
            'name' => 'Ahmad Tea Earl Grey, 500g',
            'category_id' => $blackTeaCategory->id,
            'price' => 10.99
        ]);
    }
}
