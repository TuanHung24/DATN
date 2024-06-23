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
        $capacity->name="64 GB";
        $capacity->save();
        $capacity=new Capacity();
        $capacity->name="256 GB";
        $capacity->save();
        $capacity=new Capacity();
        $capacity->name="512 GB";
        $capacity->save();
        $capacity=new Capacity();
        $capacity->name="1 TB";
        $capacity->save();
        echo "Thêm dung lượng thành công!";
    }
}
