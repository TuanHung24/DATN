<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrontCameraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('front_camera')->insert([
            ['product_description_id' => 1, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 2, 'resolution' => '10MP', 'record' => '4K@30fps', 'feature' => 'Dual video call', 'flash' => false],
            ['product_description_id' => 3, 'resolution' => '32MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 4, 'resolution' => '20MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 5, 'resolution' => '12MP', 'record' => '4K@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 6, 'resolution' => '10MP', 'record' => '4K@30fps', 'feature' => 'Dual video call', 'flash' => false],
            ['product_description_id' => 7, 'resolution' => '44MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 8, 'resolution' => '13MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 9, 'resolution' => '12MP', 'record' => '4K@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 10, 'resolution' => '32MP', 'record' => '4K@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 11, 'resolution' => '16MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 12, 'resolution' => '20MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 13, 'resolution' => '7MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 14, 'resolution' => '10MP', 'record' => '4K@30fps', 'feature' => 'Dual video call', 'flash' => false],

            ['product_description_id' => 15, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 16, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 17, 'resolution' => '10MP', 'record' => '4K@60fps', 'feature' => 'Dual video call', 'flash' => false],
            ['product_description_id' => 18, 'resolution' => '10MP', 'record' => '4K@60fps', 'feature' => 'Dual video call', 'flash' => false],
            ['product_description_id' => 19, 'resolution' => '32MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 20, 'resolution' => '32MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 21, 'resolution' => '20MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 22, 'resolution' => '20MP', 'record' => '1080p@30fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 23, 'resolution' => '12MP', 'record' => '4K@60fps', 'feature' => 'HDR', 'flash' => false],
            ['product_description_id' => 24, 'resolution' => '10MP', 'record' => '4K@60fps', 'feature' => 'Dual video call', 'flash' => false],
        ]);
    }
}
