<?php

namespace App\Http\Controllers;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getList(){
        $listNews = News::all();
        return view('news.list-news',compact('listNews'));
    }

    public function themMoi(){
        return view('news.add-new');
    }
    public function xuLyThemMoi(Request $request){
        $news= new News();
        $news->title= $request->title;
        $news->content= $request->content;
        $news->save();

    }
}
