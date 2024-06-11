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
            ['product_id' => 1, 'weight' => '174', 'os' => 'iOS', 'battery' => '3095', 'ram' => '4', 'chip' => 'A15 Bionic', 'sims' => 'Dual SIM'],
            ['product_id' => 2, 'weight' => '169', 'os' => 'Android', 'battery' => '4000', 'ram' => '8', 'chip' => 'Exynos 2100', 'sims' => 'Dual SIM'],
            ['product_id' => 3, 'weight' => '193', 'os' => 'Android', 'battery' => '4500', 'ram' => '12', 'chip' => 'Snapdragon 888', 'sims' => 'Dual SIM'],
            ['product_id' => 4, 'weight' => '196', 'os' => 'Android', 'battery' => '4600', 'ram' => '8', 'chip' => 'Snapdragon 888', 'sims' => 'Dual SIM'],
            ['product_id' => 5, 'weight' => '162', 'os' => 'iOS', 'battery' => '2815', 'ram' => '4', 'chip' => 'A14 Bionic', 'sims' => 'Dual SIM'],
            ['product_id' => 6, 'weight' => '163', 'os' => 'Android', 'battery' => '4000', 'ram' => '8', 'chip' => 'Exynos 990', 'sims' => 'Dual SIM'],
            ['product_id' => 7, 'weight' => '172', 'os' => 'Android', 'battery' => '4310', 'ram' => '8', 'chip' => 'Snapdragon 720G', 'sims' => 'Dual SIM'],
            ['product_id' => 8, 'weight' => '178', 'os' => 'Android', 'battery' => '5000', 'ram' => '6', 'chip' => 'Snapdragon 678', 'sims' => 'Dual SIM'],
            ['product_id' => 9, 'weight' => '194', 'os' => 'iOS', 'battery' => '3110', 'ram' => '4', 'chip' => 'A13 Bionic', 'sims' => 'Dual SIM'],
            ['product_id' => 10, 'weight' => '189', 'os' => 'Android', 'battery' => '4500', 'ram' => '8', 'chip' => 'Snapdragon 720G', 'sims' => 'Dual SIM'],
            ['product_id' => 11, 'weight' => '164', 'os' => 'Android', 'battery' => '4000', 'ram' => '8', 'chip' => 'Helio P95', 'sims' => 'Dual SIM'],
            ['product_id' => 12, 'weight' => '216', 'os' => 'Android', 'battery' => '5000', 'ram' => '8', 'chip' => 'Snapdragon 865', 'sims' => 'Dual SIM'],
            ['product_id' => 13, 'weight' => '148', 'os' => 'iOS', 'battery' => '1821', 'ram' => '3', 'chip' => 'A13 Bionic', 'sims' => 'Dual SIM'],
            ['product_id' => 14, 'weight' => '208', 'os' => 'Android', 'battery' => '4300', 'ram' => '8', 'chip' => 'Exynos 990', 'sims' => 'Dual SIM'],
            ['product_id' => 15, 'weight' => '171', 'os' => 'iOS', 'battery' => '3279', 'ram' => '6', 'chip' => 'A16 Bionic', 'sims' => 'Dual SIM'],
            ['product_id' => 16, 'weight' => '173', 'os' => 'iOS', 'battery' => '3279', 'ram' => '6', 'chip' => 'A15 Bionic', 'sims' => 'Dual SIM'],
            ['product_id' => 17, 'weight' => '168', 'os' => 'Android', 'battery' => '3700', 'ram' => '8', 'chip' => 'Snapdragon 8 Gen 1', 'sims' => 'Dual SIM'],
            ['product_id' => 18, 'weight' => '169', 'os' => 'Android', 'battery' => '3700', 'ram' => '8', 'chip' => 'Exynos 2200', 'sims' => 'Dual SIM'],
            ['product_id' => 19, 'weight' => '196', 'os' => 'Android', 'battery' => '5000', 'ram' => '12', 'chip' => 'Snapdragon 8 Gen 1', 'sims' => 'Dual SIM'],
            ['product_id' => 20, 'weight' => '188', 'os' => 'Android', 'battery' => '4500', 'ram' => '8', 'chip' => 'Snapdragon 8 Gen 1', 'sims' => 'Dual SIM'],
            ['product_id' => 21, 'weight' => '185', 'os' => 'Android', 'battery' => '4500', 'ram' => '12', 'chip' => 'Snapdragon 8 Gen 1', 'sims' => 'Dual SIM'],
            ['product_id' => 22, 'weight' => '179', 'os' => 'Android', 'battery' => '4500', 'ram' => '8', 'chip' => 'Snapdragon 8 Gen 1', 'sims' => 'Dual SIM'],
            ['product_id' => 23, 'weight' => '174', 'os' => 'iOS', 'battery' => '3240', 'ram' => '4', 'chip' => 'A15 Bionic', 'sims' => 'Dual SIM'],
            ['product_id' => 24, 'weight' => '171', 'os' => 'Android', 'battery' => '4000', 'ram' => '8', 'chip' => 'Exynos 2100', 'sims' => 'Dual SIM'],
        ]);
    }
}
