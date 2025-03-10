<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provider = Provider::first();
        $rootCategory = Category::create([
            'name' => 'Ahmad Tea',
            'provider_id' => $provider->id
        ]);

        Category::insert([
            ['name' => 'Black Tea', 'parent_id' => $rootCategory->id, 'provider_id' => null],
            ['name' => 'Green Tea', 'parent_id' => $rootCategory->id, 'provider_id' => null],
            ['name' => 'White Tea', 'parent_id' => $rootCategory->id, 'provider_id' => null],
        ]);
    }
}
