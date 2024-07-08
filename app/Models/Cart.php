<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    protected $fillable = [
        'customer_id',
        'product_id',
        'capacity_id',
        'color_id',
        'quantity'
    ];
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function capacity(){
        return $this->belongsTo(Capacity::class);
    }

}
