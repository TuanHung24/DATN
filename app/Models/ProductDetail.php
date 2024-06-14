<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table='product_detail';
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function capacity(){
        return $this->belongsTo(Capacity::class);
    }
    public function discount_detail(){
        return $this->hasMany(DiscountDetail::class);
    }
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }
}
