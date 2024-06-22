<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table='invoice_detail';
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function capacity(){
        return $this->belongsTo(Capacity::class);
    }
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }
    public function getIntoMoneyFormattedAttribute()
    {
        return number_format($this->into_money, 0, ',', '.');
    }
}
