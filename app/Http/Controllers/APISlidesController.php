<?php

namespace App\Http\Controllers;

use App\Models\SlideShow;
use Illuminate\Http\Request;

class APISlidesController extends Controller
{
    public function listSlides(){
        $listSlides= SlideShow::all();

        return response()->json([
            'success'=>true,
            'data'=>$listSlides
        ]);
    } 
}
