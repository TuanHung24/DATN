<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table ='comments';
    public function comment_detail(){
        return $this->hasMany(CommentDetail::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function capacity(){
        return $this->belongsTo(Capacity::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
