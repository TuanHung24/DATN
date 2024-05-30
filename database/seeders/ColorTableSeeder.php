<?php

namespace Database\Seeders;

use App\Models\Colors;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $color=new Colors();
        $color->name="Đen";
        $color->save();
        $color=new Colors();
        $color->name="Trắng";
        $color->save();
        $color=new Colors();
        $color->name="Titan";
        $color->save();
        echo "Thêm màu thành công!";
    }
}
