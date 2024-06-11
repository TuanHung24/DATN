<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RearCameraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rear_camera')->insert([
            ['product_description_id' => 1, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'Dual-LED flash', 'flash' => true],
            ['product_description_id' => 2, 'resolution' => '64MP', 'record' => '8K@24fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 3, 'resolution' => '50MP', 'record' => '4K@60fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 4, 'resolution' => '108MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 5, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'Dual-LED flash', 'flash' => true],
            ['product_description_id' => 6, 'resolution' => '12MP', 'record' => '8K@24fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 7, 'resolution' => '64MP', 'record' => '4K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 8, 'resolution' => '48MP', 'record' => '4K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 9, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'Dual-LED flash', 'flash' => true],
            ['product_description_id' => 10, 'resolution' => '64MP', 'record' => '4K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 11, 'resolution' => '48MP', 'record' => '4K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 12, 'resolution' => '64MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 13, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'Quad-LED flash', 'flash' => true],
            ['product_description_id' => 14, 'resolution' => '108MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 15, 'resolution' => '48MP', 'record' => '4K@60fps', 'feature' => 'Dual-LED flash', 'flash' => true],
            ['product_description_id' => 16, 'resolution' => '48MP', 'record' => '4K@60fps', 'feature' => 'Dual-LED flash', 'flash' => true],
            ['product_description_id' => 17, 'resolution' => '50MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 18, 'resolution' => '50MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 19, 'resolution' => '50MP', 'record' => '4K@60fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 20, 'resolution' => '50MP', 'record' => '4K@60fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 21, 'resolution' => '50MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 22, 'resolution' => '50MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
            ['product_description_id' => 23, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'Dual-LED flash', 'flash' => true],
            ['product_description_id' => 24, 'resolution' => '12MP', 'record' => '8K@30fps', 'feature' => 'LED flash', 'flash' => true],
        ]);
    }
}
