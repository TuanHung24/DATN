<?php

namespace Database\Seeders;

use App\Models\Brand;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brand = new Brand();
        $brand->name = "Apple";
        $brand->img_url = "logo_brand/logo-iphone.png";
        $brand->save();

        $brand = new Brand();
        $brand->name = "Samsung";
        $brand->img_url = "logo_brand/logo-samsung.png";
        $brand->save();

        $brand = new Brand();
        $brand->name = "Oppo";
        $brand->img_url = "logo_brand/logo-oppo.jpg";
        $brand->save();

        $brand = new Brand();
        $brand->name = "Xiaomi";
        $brand->img_url = "logo_brand/logo-xiaomi.png";
        $brand->save();

        echo "Thêm Brand thành công!";
    }
}
