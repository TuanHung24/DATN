<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'iPhone 13', 'description' => 'Apple iPhone 13', 'brand_id' => 1, 'product_series_id' => 4],
            ['name' => 'iPhone 11', 'description' => 'Apple iPhone 11', 'brand_id' => 1, 'product_series_id' => 1],
            ['name' => 'Samsung Galaxy S21', 'description' => 'Samsung Galaxy S21', 'brand_id' => 2, 'product_series_id' => 2],
            ['name' => 'iPhone 12', 'description' => 'Apple iPhone 12', 'brand_id' => 1, 'product_series_id' => 3]
        ]);
    }
}
