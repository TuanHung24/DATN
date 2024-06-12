<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SlideShow;
use App\Models\Product;
use Exception;

class SlideShowController extends Controller
{
    public function getList(){
        $listSlide = SlideShow::paginate(3);
        return view('slide-show.list',compact('listSlide'));
    }

    public function addNew(){
        $listProduct = Product::all();
        return view('slide-show.add-new',compact('listProduct'));
    }
    public function hdAddNew(Request $request){
        try{
            $file = $request->file('img_url');
            $slideshow = new SlideShow();
        if(isset($file)){
            $path = $file->store('slide');
            $slideshow->img_url = $path;
        }
        $slideshow->product_id= $request->product;
        $slideshow->save();
            
        return redirect()->route('slide-show.list')->with(['Success'=>'Thêm Slideshow thành công!']);
        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
        

    }
}
