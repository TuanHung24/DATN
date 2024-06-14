<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontCamera extends Model
{
    use HasFactory;
    protected $table='front_camera';
    public function product_descriptions()
    {
        return $this->hasMany(ProductDescription::class, 'front_camera_id');
    }
}
