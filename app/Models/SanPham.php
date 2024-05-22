<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;
    protected $table = "san_pham";
    public function loai_san_pham()
    {
        return $this->belongsTo(LoaiSanPham::class);
    }
}




