<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $table = 'warehouse';
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function getTotalFormattedAttribute()
    {
        return number_format($this->total, 0, ',', '.');
    }
}
