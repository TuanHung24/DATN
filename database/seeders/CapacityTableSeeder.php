<?php

namespace Database\Seeders;

use App\Models\Capacity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CapacityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capacity=new Capacity();
        $capacity->name="64GB";
        $capacity->save();
        $capacity=new Capacity();
        $capacity->name="256GB";
        $capacity->save();
        $capacity=new Capacity();
        $capacity->name="512GB";
        $capacity->save();
        $capacity=new Capacity();
        $capacity->name="1TB";
        $capacity->save();
        echo "Thêm dung lượng thành công!";
    }
}
