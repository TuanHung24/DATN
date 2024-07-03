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
            ['name' => 'iPhone 13', 'description' => 'Online giá siêu rẻ', 'brand_id' => 1, 'product_series_id' => 4],
            ['name' => 'iPhone 11', 'description' => 'Online giá siêu rẻ', 'brand_id' => 1, 'product_series_id' => 1],
            ['name' => 'Samsung Galaxy S21', 'description' => 'Online giá siêu rẻ', 'brand_id' => 2, 'product_series_id' => 2],
            ['name' => 'iPhone 12', 'description' => 'Online giá siêu rẻ', 'brand_id' => 1, 'product_series_id' => 3],
            [
                'name' => 'Samsung Galaxy Note 20',
                'description' => 'Online giá siêu rẻ',
                'brand_id' => 2, 
                'product_series_id' => 2
            ],
            [
                'name' => 'Oppo Find X3 Pro',
                'description' => 'Online giá siêu rẻ',
                'brand_id' => 3, // Oppo
                'product_series_id' => 5,
               
            ],
            [
                'name' => 'Xiaomi Mi 11',
                'description' => 'Online giá siêu rẻ',
                'brand_id' => 4, // Xiaomi
                'product_series_id' => 6,
                
            ],
            [
                'name' => 'Xiaomi Redmi Note 10',
                'description' => 'Online giá siêu rẻ',
                'brand_id' => 4, // Xiaomi
                'product_series_id' => 6,
               
            ],
            [
                'name' => 'Samsung Galaxy A52',
                'description' => 'Online giá siêu rẻ',
                'brand_id' => 2, // Samsung
                'product_series_id' => 2
            ],
        ]);
    }
}
