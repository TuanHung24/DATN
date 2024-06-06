<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountDetail extends Model
{
    use HasFactory;
    protected $table = 'discount_detail';
    public function product_detail(){
        return $this->belongsTo(ProductDetail::class);
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }
    
    public function isActive()
    {
        $now = now();
        return $this->discount->date_start <= $now && $this->discount->date_end >= $now;
    }
    
}
