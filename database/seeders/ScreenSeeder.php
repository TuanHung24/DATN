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
            ['product_description_id' => 1, 'technoscreen' => 'OLED', 'resolution' => '1170 x 2532', 'size' => '6.1', 'brightness' => '800'],
            ['product_description_id' => 2, 'technoscreen' => 'Dynamic AMOLED 2X', 'resolution' => '1080 x 2400', 'size' => '6.2', 'brightness' => '1300'],
            ['product_description_id' => 3, 'technoscreen' => 'AMOLED', 'resolution' => '1080 x 2400', 'size' => '6.7', 'brightness' => '1000'],
            ['product_description_id' => 4, 'technoscreen' => 'AMOLED', 'resolution' => '1440 x 3200', 'size' => '6.81', 'brightness' => '1500'],
            ['product_description_id' => 5, 'technoscreen' => 'OLED', 'resolution' => '1170 x 2532', 'size' => '6.1', 'brightness' => '625'],
            ['product_description_id' => 6, 'technoscreen' => 'Dynamic AMOLED 2X', 'resolution' => '1440 x 3200', 'size' => '6.2', 'brightness' => '1200'],
            ['product_description_id' => 7, 'technoscreen' => 'AMOLED', 'resolution' => '1080 x 2400', 'size' => '6.43', 'brightness' => '750'],
            ['product_description_id' => 8, 'technoscreen' => 'AMOLED', 'resolution' => '1080 x 2400', 'size' => '6.43', 'brightness' => '1100'],
            ['product_description_id' => 9, 'technoscreen' => 'Liquid Retina IPS LCD', 'resolution' => '828 x 1792', 'size' => '6.1', 'brightness' => '625'],
            ['product_description_id' => 10, 'technoscreen' => 'Super AMOLED', 'resolution' => '1080 x 2400', 'size' => '6.5', 'brightness' => '800'],
            ['product_description_id' => 11, 'technoscreen' => 'AMOLED', 'resolution' => '1080 x 2400', 'size' => '6.43', 'brightness' => '430'],
            ['product_description_id' => 12, 'technoscreen' => 'IPS LCD', 'resolution' => '1080 x 2400', 'size' => '6.67', 'brightness' => '500'],
            ['product_description_id' => 13, 'technoscreen' => 'Retina IPS LCD', 'resolution' => '750 x 1334', 'size' => '4.7', 'brightness' => '625'],
            ['product_description_id' => 14, 'technoscreen' => 'Super AMOLED Plus', 'resolution' => '1080 x 2400', 'size' => '6.7', 'brightness' => '1200'],

            ['product_description_id' => 15, 'technoscreen' => 'Super Retina XDR', 'resolution' => '1179 x 2556', 'size' => '6.1', 'brightness' => '1000'],
            ['product_description_id' => 16, 'technoscreen' => 'Super Retina XDR', 'resolution' => '1170 x 2532', 'size' => '6.1', 'brightness' => '1000'],
            ['product_description_id' => 17, 'technoscreen' => 'Dynamic AMOLED 2X', 'resolution' => '1080 x 2340', 'size' => '6.1', 'brightness' => '1300'],
            ['product_description_id' => 18, 'technoscreen' => 'Dynamic AMOLED 2X', 'resolution' => '1080 x 2340', 'size' => '6.1', 'brightness' => '1300'],
            ['product_description_id' => 19, 'technoscreen' => 'AMOLED', 'resolution' => '1440 x 3216', 'size' => '6.7', 'brightness' => '1300'],
            ['product_description_id' => 20, 'technoscreen' => 'AMOLED', 'resolution' => '1080 x 2400', 'size' => '6.4', 'brightness' => '1100'],
            ['product_description_id' => 21, 'technoscreen' => 'AMOLED', 'resolution' => '1440 x 3200', 'size' => '6.67', 'brightness' => '1200'],
            ['product_description_id' => 22, 'technoscreen' => 'AMOLED', 'resolution' => '1080 x 2400', 'size' => '6.28', 'brightness' => '1100'],
            ['product_description_id' => 23, 'technoscreen' => 'Super Retina XDR', 'resolution' => '1170 x 2532', 'size' => '6.1', 'brightness' => '1000'],
            ['product_description_id' => 24, 'technoscreen' => 'Dynamic AMOLED 2X', 'resolution' => '1080 x 2400', 'size' => '6.2', 'brightness' => '1300'],
        ]);
    }
}
