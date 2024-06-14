<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgProduct extends Model
{
    use HasFactory;
    protected $table ='img_product';
    public function color(){
        return $this->belongsTo(Color::class,'color_id');
    }
}
