<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    public function product_detail()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function product_series()
    {
        return $this->belongsTo(ProductSeries::class);
    }
    public function product_description()
    {
        return $this->hasOne(ProductDescription::class, 'product_id');
    }
    public function img_product()
    {
        return $this->hasMany(ImgProduct::class, 'product_id');
    }
    public function rate()
    {
        return $this->hasMany(Rate::class, 'product_id');
    }
    public function imgProductByColor($colorId)
    {
        return $this->hasMany(ImgProduct::class)->where('color_id', $colorId);
    }
}
