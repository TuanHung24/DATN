<?php

namespace App\Http\Controllers;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class NewsController extends Controller
{
    public function getList(){
        $listNews = News::paginate(5);
        return view('news.list',compact('listNews'));
    }

    public function addNew(){
        return view('news.add-new');
    }
    public function hdAddNew(Request $request){
        try{

            $news= new News();
            $news->title= $request->title;
            $news->content= $request->content;
            $news->save();

        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
        

    }
}
