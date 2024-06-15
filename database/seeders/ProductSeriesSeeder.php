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
        $productSeries->name="Iphone 11 Series";
        $productSeries->save();
        
        $productSeries=new ProductSeries();
        $productSeries->name="Samsung Galaxy Series";
        $productSeries->save();

        $productSeries=new ProductSeries();
        $productSeries->name="Iphone 12 Series";
        $productSeries->save();
        
        $productSeries=new ProductSeries();
        $productSeries->name="Iphone 13 Series";
        $productSeries->save();

        echo "Thêm Series thành công!";
    }
}