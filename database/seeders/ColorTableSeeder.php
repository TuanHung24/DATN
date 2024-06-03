<?php

namespace Database\Seeders;

use App\Models\Color;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $color=new Color();
        $color->name="Đen";
        $color->save();
        $color=new Color();
        $color->name="Trắng";
        $color->save();
        $color=new Color();
        $color->name="Titan";
        $color->save();
        echo "Thêm màu thành công!";
    }
}
