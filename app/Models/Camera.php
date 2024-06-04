<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    use HasFactory;
    protected $table='camera';
    public function frontcamera(){
        return $this->belongsTo(FrontCamera::class);
    }
    public function rearcamera(){
        return $this->belongsTo(RearCamera::class);
    }
}
