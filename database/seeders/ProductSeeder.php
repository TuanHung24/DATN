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
            ['name' => 'iPhone 13', 'description' => 'Apple iPhone 13', 'brand_id' => 1],
            ['name' => 'Samsung Galaxy S21', 'description' => 'Samsung Galaxy S21', 'brand_id' => 2],
            ['name' => 'Oppo Find X3', 'description' => 'Oppo Find X3', 'brand_id' => 3],
            ['name' => 'Xiaomi Mi 11', 'description' => 'Xiaomi Mi 11', 'brand_id' => 4],
            ['name' => 'iPhone 12', 'description' => 'Apple iPhone 12', 'brand_id' => 1],
            ['name' => 'Samsung Galaxy S20', 'description' => 'Samsung Galaxy S20', 'brand_id' => 2],
            ['name' => 'Oppo Reno5', 'description' => 'Oppo Reno5', 'brand_id' => 3],
            ['name' => 'Xiaomi Redmi Note 10', 'description' => 'Xiaomi Redmi Note 10', 'brand_id' => 4],
            ['name' => 'iPhone 11', 'description' => 'Apple iPhone 11', 'brand_id' => 1],
            ['name' => 'Samsung Galaxy A52', 'description' => 'Samsung Galaxy A52', 'brand_id' => 2],
            ['name' => 'Oppo A93', 'description' => 'Oppo A93', 'brand_id' => 3],
            ['name' => 'Xiaomi Mi 10T', 'description' => 'Xiaomi Mi 10T', 'brand_id' => 4],
            ['name' => 'iPhone SE', 'description' => 'Apple iPhone SE', 'brand_id' => 1],
            ['name' => 'Samsung Galaxy Note 20', 'description' => 'Samsung Galaxy Note 20', 'brand_id' => 2],
            ['name' => 'iPhone 15', 'description' => 'Apple iPhone 15', 'brand_id' => 1],
            ['name' => 'iPhone 14', 'description' => 'Apple iPhone 14', 'brand_id' => 1],
            ['name' => 'Samsung Galaxy S23', 'description' => 'Samsung Galaxy S23', 'brand_id' => 2],
            ['name' => 'Samsung Galaxy S22', 'description' => 'Samsung Galaxy S22', 'brand_id' => 2],
            ['name' => 'Oppo Find X6', 'description' => 'Oppo Find X6', 'brand_id' => 3],
            ['name' => 'Oppo Reno8', 'description' => 'Oppo Reno8', 'brand_id' => 3],
            ['name' => 'Xiaomi 13', 'description' => 'Xiaomi 13', 'brand_id' => 4],
            ['name' => 'Xiaomi 12', 'description' => 'Xiaomi 12', 'brand_id' => 4],
            ['name' => 'iPhone 13', 'description' => 'Apple iPhone 13', 'brand_id' => 1],
            ['name' => 'Samsung Galaxy S21', 'description' => 'Samsung Galaxy S21', 'brand_id' => 2],
            
        ]);
    }
}
