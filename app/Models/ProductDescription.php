<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;
    protected $table ='product_description';
    public function camera(){
        return $this->hasOne(Camera::class);
    }
    public function screen(){
        return $this->belongsTo(Screen::class,'screen_id');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function front_camera(){
        return $this->belongsTo(FrontCamera::class,'front_camera_id');
    }
    public function rear_camera(){
        return $this->belongsTo(RearCamera::class,'rear_camera_id');
    }

}
