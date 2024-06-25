<?php

namespace Database\Seeders;
use App\Models\Logo;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logo=new Logo();
        $logo->img_url="logo/CqmxUBOzsq2XHQXFQui976nkibIOFbAXULN7bQ3d.png";
        $logo->save();
        echo "Them logo thanh cong";
    }
}
