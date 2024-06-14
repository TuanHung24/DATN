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
            [
                'resolution' => '48 MP',
                'record' => '8K at 24 fps',
                'feature' => 'Night Mode, Pro Mode, Ultra-wide',
                'flash' => true,
                
            ],
            [
                'resolution' => '12 MP',
                'record' => '4K at 60 fps',
                'feature' => 'HDR10+, Super Steady',
                'flash' => true,
               
            ],
            [
                'resolution' => '64 MP',
                'record' => '4K at 30 fps',
                'feature' => 'Ultra-wide, Macro, Depth Sensor',
                'flash' => true,
                
            ],
            [
                'resolution' => '108 MP',
                'record' => '8K at 30 fps',
                'feature' => 'Periscope, Night Mode',
                'flash' => true,
                
            ],
            [
                'resolution' => '24 MP',
                'record' => '4K at 60 fps',
                'feature' => 'HDR, Slow Motion',
                'flash' => true,
                
            ],
            [
                'resolution' => '16 MP',
                'record' => '1080p at 30 fps',
                'feature' => 'Wide Angle, Panorama',
                'flash' => false,
               
            ],
        ]);
    }
}
