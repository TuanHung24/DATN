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
        $brand=new Brand();
        $brand->name="Apple";
        $brand->save();
        
        $brand=new Brand();
        $brand->name="Samsung";
        $brand->save();

        $brand=new Brand();
        $brand->name="Oppo";
        $brand->save();
        
        $brand=new Brand();
        $brand->name="Xiaomi";
        $brand->save();

        echo "Thêm Brand thành công!";
    }
}
