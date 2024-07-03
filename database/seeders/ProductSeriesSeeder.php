<?php

namespace Database\Seeders;
use App\Models\ProductSeries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productSeries=new ProductSeries();
        $productSeries->name="Iphone 11";
        $productSeries->save();
        
        $productSeries=new ProductSeries();
        $productSeries->name="Samsung Galaxy";
        $productSeries->save();

        $productSeries=new ProductSeries();
        $productSeries->name="Iphone 12";
        $productSeries->save();
        
        $productSeries=new ProductSeries();
        $productSeries->name="Iphone 13";
        $productSeries->save();

        $productSeries=new ProductSeries();
        $productSeries->name="Oppo Find";
        $productSeries->save();

        $productSeries=new ProductSeries();
        $productSeries->name="Xiaomi Mi";
        $productSeries->save();

        echo "Thêm Series thành công!";
    }
}
