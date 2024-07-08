<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table='invoice';
    const TRANG_THAI_CHO_XU_LY = 1; 
    const TRANG_THAI_DA_DUYET = 2;
    const TRANG_THAI_DANG_GIAO = 3;
    const TRANG_THAI_HOAN_THANH = 4;
    const TRANG_THAI_DA_HUY = 5;
    const TRANG_THAI_HOAN_TRA = 6;
    public function invoice_detail(){
        return $this->hasMany(InvoiceDetail::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function getTotalFormattedAttribute()
    {
        return number_format($this->total, 0, ',', '.');
    }
}
