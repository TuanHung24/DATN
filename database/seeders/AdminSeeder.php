<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = "Âu Tuấn Hưng";
        $admin->email = "hung@gmail.com";
        $admin->username = "TuanHung";
        $admin->password = Hash::make(123);
        $admin->phone = "0937116413";
        $admin->address = "Quận Bình Thanh, TP.HCM";
        $admin->roles = 1;
        $admin->save();
        $admin = new Admin();
        $admin->name = "Mai Văn Khải";
        $admin->email = "khaimen57@gmail.com";
        $admin->username = "MaiKhai";
        $admin->password = Hash::make(123);
        $admin->phone = "0368193004";
        $admin->address = "Quận Gò Vấp, TP.HCM";
        $admin->roles = 1;
        $admin->save();
    }
}
