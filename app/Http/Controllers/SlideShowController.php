<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use App\Models\SlideShow;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Storage;

class SlideShowController extends Controller
{

    public function search(Request $request)
    {
        try {

            $query = $request->input('query');
            $listSlide = SlideShow::where('product.name', 'like', '%' . $query . '%')
                ->paginate(3);
            return view('slide-show.list', compact('listSlide', 'query'));
        } catch (Exception $e) {
            return back()->with(['Error' => 'Không tìm thấy khách hàng']);
        }
    }
    public function getList()
    {
        $listSlide = SlideShow::paginate(3);
        $loGo = Logo::first();
        return view('slide-show.list', compact('listSlide','loGo'));
    }

    public function addNew()
    {
        $listProduct = Product::all();
        return view('slide-show.add-new', compact('listProduct'));
    }
    public function hdAddNew(Request $request)
    {
        try {
            $file = $request->file('img_url');
            $slideshow = new SlideShow();
            if (isset($file)) {
                $path = $file->store('slide');
                $slideshow->img_url = $path;
            }
            $slideshow->product_id = $request->product;
            $slideshow->save();

            return redirect()->route('slide-show.list')->with(['Success' => 'Thêm Slideshow thành công!']);
        } catch (Exception $e) {
            return back()->with("error: " . $e);
        }
    }
    public function upDate($id)
    {
        $slide = SlideShow::findOrFail($id);
        $dsProduct = Product::all();
        if (empty($slide)) {
            return redirect()->route('slide-show.list')->with(['Error' => "Tài khoản này không tồn tại!"]);
        }
        return view('slide-show.update', compact('slide', 'dsProduct'));
    }
    public function hdUpdate(Request $request, $id)
    {

        try {

            $file = $request->file('img_url');
            $slideshow = SlideShow::findOrFail($id);

            if (isset($file)) {
                Storage::delete($slideshow->img_url);
                $path = $file->store('slide');
                $slideshow->img_url = $path;
            }
            $slideshow->product_id = $request->product_id;
            $slideshow->save();
            return redirect()->route('slide-show.list')->with(['Success' => "Cập nhật slide {$slideshow->id} thành công!"]);
        } catch (Exception $e) {
            return back()->withInput()->with(['error' => "Error: " . $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $slide = SlideShow::findOrFail($id);
        if (!empty($slide->img_url)) {
            $imgPath = $slide->img_url;
            if (file_exists(public_path($imgPath))) {
                unlink(public_path($imgPath));
                $slide->delete();
            }
        }
        return redirect()->route('slide-show.list')->with(['Success' => " Xóa slide thành công!"]);
    }
    public function updateLogo(Request $request, $id){

        try{
        $file = $request->file('logo');
        $loGo = Logo::findOrFail($id);
        
        if(isset($file)){
            Storage::delete($loGo->img_url);
            $path = $file->store('logo');
            $loGo->img_url = $path;
        } 
            $loGo->save();
        return redirect()->route('slide-show.list')->with(['Success'=>"Cập nhật logo thành công!"]);
        }catch(Exception $e){
            return back()->withInput()->with(['error' => "Error: " . $e->getMessage()]);
        }
    }
}
