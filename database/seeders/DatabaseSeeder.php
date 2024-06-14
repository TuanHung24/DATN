<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            BrandTableSeeder::class,
            CapacityTableSeeder::class,
            ColorTableSeeder::class,
            ProductSeeder::class,
            FrontCameraSeeder::class,
            RearCameraSeeder::class,
            ScreenSeeder::class,
            ProductDescriptionSeeder::class,
        ]);
    }
}
