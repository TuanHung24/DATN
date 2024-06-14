<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('screen')->insert([
            [
                'technoscreen' => 'OLED',
                'resolution' => '1440 x 3200 pixels',
                'size' => '6.5 inches',
                'brightness' => '800 nits',
                
            ],
            [
                'technoscreen' => 'LCD',
                'resolution' => '1080 x 2400 pixels',
                'size' => '6.1 inches',
                'brightness' => '600 nits',
                
            ],
            [
                'technoscreen' => 'AMOLED',
                'resolution' => '2340 x 1080 pixels',
                'size' => '6.7 inches',
                'brightness' => '1000 nits',
                
            ],
            [
                'technoscreen' => 'Super AMOLED',
                'resolution' => '3040 x 1440 pixels',
                'size' => '6.4 inches',
                'brightness' => '900 nits',
                
            ],
            [
                'technoscreen' => 'Retina',
                'resolution' => '2532 x 1170 pixels',
                'size' => '6.2 inches',
                'brightness' => '1100 nits',
                
            ],
            [
                'technoscreen' => 'Dynamic AMOLED',
                'resolution' => '3200 x 1440 pixels',
                'size' => '6.8 inches',
                'brightness' => '1200 nits',
                
            ],
        ]);
    }
}
