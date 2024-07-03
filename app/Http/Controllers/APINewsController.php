<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class APINewsController extends Controller
{
    public function listNews(){
        $listNews = News::orderByDesc('id')->paginate(2);

        return response()->json([
            'success'=>true,
            'data'=>$listNews
        ]);
    } 
    public function listNewDetail($title){
        $News= News::findOrFail($title);

        return response()->json([
            'success'=>true,
            'data'=>$News
        ]);
    }
}
