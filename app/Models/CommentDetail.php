<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentDetail extends Model
{
    use HasFactory;
    protected $table = 'comment_detail';
    public function comment(){
        return $this->belongsTo(Comment::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
