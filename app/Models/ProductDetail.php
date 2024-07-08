<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table='product_detail';
    protected $fillable = [
        'product_id', 'color_id', 'capacity_id', 'price', 'quantity', 
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function color(){
        return $this->belongsTo(Color::class,'color_id');
    }
    public function capacity(){
        return $this->belongsTo(Capacity::class,'capacity_id');
    }
    public function discount_detail(){
        return $this->hasMany(DiscountDetail::class);
    }
    public function img_product(){
        return $this->hasMany(ImgProduct::class, 'product_id', 'product_id')
                    ->where('color_id', $this->color_id);
    }
    // public function img_product()
    // {
    //     return $this->hasOne(ImgProduct::class, 'product_id', 'product_id')
    //                 ->where('color_id', $this->color_id) // Lọc theo color_id của product_detail
    //                 ->orderBy('id') // Sắp xếp và lấy cái đầu tiên
    //                 ->select('id', 'img_url');
    // }
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }
}
