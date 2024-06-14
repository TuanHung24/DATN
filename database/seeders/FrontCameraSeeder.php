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
            [
                'resolution' => '12 MP',
                'record' => '4K at 30 fps',
                'feature' => 'Auto-HDR, Panorama',
                'flash' => true,
                
            ],
            [
                'resolution' => '8 MP',
                'record' => '1080p at 30 fps',
                'feature' => 'HDR, Portrait Mode',
                'flash' => false,
                
            ],
            [
                'resolution' => '16 MP',
                'record' => '1080p at 60 fps',
                'feature' => 'Night Mode, Wide Angle',
                'flash' => false,
               
            ],
            [
                'resolution' => '20 MP',
                'record' => '4K at 60 fps',
                'feature' => 'Super Steady, Portrait Mode',
                'flash' => true,
                
            ],
            [
                'resolution' => '32 MP',
                'record' => '4K at 30 fps',
                'feature' => 'AI Beauty, HDR',
                'flash' => true,
                
            ],
            [
                'resolution' => '10 MP',
                'record' => '1080p at 30 fps',
                'feature' => 'Auto-HDR, Panorama',
                'flash' => false,
                
            ],
        ]);
    }
}
