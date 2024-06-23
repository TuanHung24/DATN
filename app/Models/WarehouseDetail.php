<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    use HasFactory;
    protected $table = 'warehouse_detail'; 
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'color_id',
        'capacity_id',
        'quantity',
        'in_price',
        'out_price',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function capacity(){
        return $this->belongsTo(Capacity::class);
    }
    public function getIntoMoneyFormattedAttribute()
    {
        return number_format($this->into_money, 0, ',', '.');
    }
    public function getInPriceFormattedAttribute()
    {
        return number_format($this->in_price, 0, ',', '.');
    }
    public function getOutPriceFormattedAttribute()
    {
        return number_format($this->out_price, 0, ',', '.');
    }
}
