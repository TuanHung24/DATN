<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;
    protected $table ='product_description';
    public function camera(){
        return $this->hasMany(Camera::class);
    }
    public function screen(){
        return $this->hasMany(Screen::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
