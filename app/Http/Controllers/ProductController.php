<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\ImgProduct;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getList(){
        $listProduct = Product::paginate(8);
        $listProductDelete=Product::onlyTrashed()->get();
        return view('product.list', compact('listProduct','listProductDelete'));
    }
    public function addNew(){
        $listBrand = Brand::all();
        return view('product.add-new', compact('listBrand'));
    }
    public function hdAddNew(ProductRequest $request){


        $files=$request->img;
        $paths=[];
        
        foreach($files as $file)
        {
            if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpg', 'png', 'jpeg'])) {
                // Kiểm tra kích thước của từng tệp tin
                $maxSize = 10240; // 10MB
                if ($file->getSize() <= $maxSize * 1024) { // Chuyển đổi sang byte
                    $paths[] = $file->store('img-product');
                } else {
                    // Kích thước hình ảnh quá lớn
                    return redirect()->back()->with(['error'=>"Kích thước hình ảnh quá lớn. Vui lòng chọn hình ảnh nhỏ hơn 10MB."]);
                }
            } else {
                // Tệp không phải là hình ảnh
                return redirect()->back()->with(['error'=>"Tệp không phải là hình ảnh jpg, png, hoặc jpeg."]);
            }
           
        }     

        $proDuct = new Product();
        $proDuct->name= $request->name;
        $proDuct->description= $request->description;
        $proDuct->brand_id= $request->brand;
        $proDuct->save();

        $productDes= new ProductDescription();
        $productDes->product_id = $proDuct->id;
        // $productDes->camera_id = 1;
        // $productDes->screen_id = 1;
        $productDes->weight = $request->weight;
        $productDes->os = $request->os;
        $productDes->battery = $request->battery;
        $productDes->ram = $request->ram;
        $productDes->chip = $request->weight;
        $productDes->sims = $request->sims;
        $productDes->save();

        for($i=0;$i<count($request->img);$i++){
            $imgProduct = new ImgProduct();
            $imgProduct->product_id= $proDuct->id;
            $imgProduct->img_url= $paths[$i];
            $imgProduct->save();
        }
        
        return redirect()->route('product.list');
        
    }
    public function upDate($id){
        $proDuct = Product::find($id);
        $listBrand = Brand::all();
        $productDes = ProductDescription::where('product_id',$id)->first();
        return view('product.update',compact('proDuct','listBrand','productDes'));
    }
    public function hdUpdate(ProductRequest $request, $id){
        
        $proDuct = Product::find($id);
        if(!$proDuct){
           return redirect()->route('product.list')->with(["thong_bao"=>"Sản phẩm không tồn tại!"]);
        }
        $files=$request->img;
        $proDuct->name= $request->name;
        $proDuct->description= $request->description;
        $proDuct->brand_id= $request->brand;
        $proDuct->save();

        $productDes=ProductDescription::where('product_id',$id)->first();
        $productDes->product_id = $proDuct->id;
        // $productDes->camera_id = 1;
        // $productDes->screen_id = 1;
        $productDes->weight = $request->weight;
        $productDes->os = $request->os;
        $productDes->battery = $request->battery;
        $productDes->ram = $request->ram;
        $productDes->chip = $request->chip;
        $productDes->sims = $request->sims;
        $productDes->save();

        if(!empty($files))
        {
            $paths=[];
            
            foreach($files as $file)
            {
                if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpg', 'png', 'jpeg'])) {
                    // Kiểm tra kích thước của từng tệp tin
                    $maxSize = 1024; // 1MB
                    if ($file->getSize() <= $maxSize * 1024) { // Chuyển đổi sang byte
                        $paths[] = $file->store('img-product');
                    } else {
                        // Kích thước hình ảnh quá lớn
                        return redirect()->back()->with(['error'=>"Kích thước hình ảnh quá lớn. Vui lòng chọn hình ảnh nhỏ hơn 10MB."]);
                    }
                } else {
                    // Tệp không phải là hình ảnh
                    return redirect()->back()->with(['error'=>"Tệp không phải là hình ảnh jpg, png, hoặc jpeg."]);
                }
            
            }
           
            for($i=0;$i<count($paths);$i++)
            {
                $imgProduct = new ImgProduct();
                $imgProduct->product_id= $proDuct->id;
                $imgProduct->img_url= $paths[$i];
                $imgProduct->save();
            }
        }  
        return redirect()->route('product.list')->with(['Success'=>"Cập nhật sản phẩm {$proDuct->ten} thành công!"]);
    }
    public function getProductDetail($id){
        $listProductDetail = ProductDetail::where('product_id', $id)->get();
        $productDescription = ProductDescription::where('product_id', $id)->first();
        $proDuct = Product::find($id);
        $listImg = ImgProduct::where('product_id', $id)->get();
        return view('product.detail', compact('listProductDetail','proDuct','listImg','productDescription'));
    }

    public function delete($id)
    {
        $proDuct = Product::find($id);
        if (empty($proDuct)) {
            return "Sản phẩm không tồn tại";
        }
        $proDuct->delete();
        return redirect()->route('product.list')->with(['Success'=>"Xóa sản phẩm {$proDuct->name} thành công!"]);
    }
   
    public function restore($id)
    {
        $proDuct=Product::withTrashed()->find($id);
        $proDuct->restore();
        return redirect()->route('product.list')->with(['Success'=>"Phục hồi sản phẩm {$proDuct->name} thành công "]);
    }
    
    public function deleted($id)
    {
        $proDuct=Product::withTrashed()->find($id);
        $proDuct->forceDelete();
        return redirect()->route('product.list')->with(['Success'=>"Xóa vĩnh viễn sản phẩm {$proDuct->name} thành công "]);
    }
    
}
