<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discount';
    public function discount_detail(){
        return $this->hasMany(DiscountDetail::class);
    }
    public function getFormattedDateStartAttribute()
    {
        return Carbon::parse($this->date_start)->format('d/m/Y H:i');
    }

    public function getFormattedDateEndAttribute()
    {
        return Carbon::parse($this->date_end)->format('d/m/Y H:i');
    }
}
