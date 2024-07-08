<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $table = 'colors';
    public function img_product(){
        return $this->hasMany(ImgProduct::class,'color_id');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
