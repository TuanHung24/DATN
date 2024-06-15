<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_description')->insert([
            [
                'product_id' => 1, // Replace with actual product IDs from products table
                'front_camera_id' => 1,
                'rear_camera_id' => 1,
                'screen_id' => 1,
                'weight' => '200',
                'os' => 'Android 12',
                'battery' => '4500',
                'ram' => '8',
                'chip' => 'Snapdragon 888',
                'sims' => 'Dual SIM (Nano-SIM, dual stand-by)',
                
            ],
            [
                'product_id' => 2, // Replace with actual product IDs from products table
                'front_camera_id' => 2,
                'rear_camera_id' => 2,
                'screen_id' => 2,
                'weight' => '180',
                'os' => 'iOS 15',
                'battery' => '3095',
                'ram' => '4',
                'chip' => 'A15 Bionic',
                'sims' => 'Dual SIM (Nano-SIM and eSIM)',
                
            ],
            [
                'product_id' => 3, // Replace with actual product IDs from products table
                'front_camera_id' => 3,
                'rear_camera_id' => 3,
                'screen_id' => 3,
                'weight' => '210',
                'os' => 'Android 11',
                'battery' => '5000',
                'ram' => '6',
                'chip' => 'Exynos 2100',
                'sims' => 'Single SIM (Nano-SIM) or Dual SIM (Nano-SIM, dual stand-by)',
                
            ],
            [
                'product_id' => 4, // Replace with actual product IDs from products table
                'front_camera_id' => 4,
                'rear_camera_id' => 4,
                'screen_id' => 4,
                'weight' => '190',
                'os' => 'Android 13',
                'battery' => '4800',
                'ram' => '12',
                'chip' => 'Snapdragon 8 Gen 1',
                'sims' => 'Dual SIM (Nano-SIM, dual stand-by)',
                
            ],
        ]);
    }
}
