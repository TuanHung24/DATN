<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DiscountDetail extends Model
{
    use HasFactory;
    protected $table = 'discount_detail';
    
    public function product_detail()
    {
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
    public function scopeIsActive($query)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        return $query->whereHas('discount', function($query) use ($now) {
            $query->where('date_start', '<=', $now)->where('date_end', '>=', $now);
        });
    }
    public function isActive($id)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $discount = $this->discount()->find($id);
        if ($discount) {
            return $this->date_start <= $now && $this->date_end >= $now;
        }
        return false;
    }
}
