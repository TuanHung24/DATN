<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $table = 'warehouse';
    protected $fillable = [ 
        'provider_id',
        'date',
        'total',
        
    ];

    // Định nghĩa mối quan hệ với WarehouseDetail
    public function warehouse_detail()
    {
        return $this->hasMany(WarehouseDetail::class);
    }
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function getTotalFormattedAttribute()
    {
        return number_format($this->total, 0, ',', '.');
    }
}
