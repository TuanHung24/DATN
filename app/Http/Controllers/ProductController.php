<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\ProductSeries;
use App\Models\Capacity;
use App\Models\Color;
use App\Models\FrontCamera;
use App\Models\ImgProduct;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductDetail;
use App\Models\RearCamera;
use App\Models\Screen;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getList()
    {
        $listProduct = Product::paginate(8);
        $listProductDelete = Product::onlyTrashed()->get();
        return view('product.list', compact('listProduct', 'listProductDelete'));
    }
    public function addNew()
    {
        $listBrand = Brand::all();
        $listFrontCamera = FrontCamera::all();
        $listRearCamera = RearCamera::all();
        $listScreen = Screen::all();
        $listColors = Color::all();
        $listCapacity = Capacity::all();
        $listSeries = ProductSeries::all();
        return view('product.add-new', compact('listBrand','listSeries', 'listFrontCamera', 'listRearCamera', 'listScreen', 'listColors', 'listCapacity'));
    }
    public function hdAddNew(Request $request)
    {



        try {



            $proDuct = new Product();
            
            $proDuct->name = $request->product_name;
            $proDuct->description = $request->hd_description;
            $proDuct->brand_id = $request->brand_id;
            $proDuct->product_series_id = $request->product_series_id;
            $proDuct->save();

            $productDes = new ProductDescription();
            $productDes->product_id = $proDuct->id;
            $productDes->front_camera_id = $request->hd_front_camera;
            $productDes->rear_camera_id = $request->hd_rear_camera;
            $productDes->screen_id = $request->hd_screen;
            $productDes->weight = $request->hd_weight;
            $productDes->os = $request->hd_os;
            $productDes->battery = $request->hd_battery;
            $productDes->ram = $request->hd_ram;
            $productDes->chip = $request->hd_chip;
            $productDes->sims = $request->hd_sims;
            $productDes->save();

            for ($i = 0; $i < count($request->color_id); $i++) {
                $productDetail = new ProductDetail();
                $productDetail->product_id = $proDuct->id;
                $productDetail->color_id = $request->color_id[$i];
                $productDetail->capacity_id = $request->capacity_id[$i];
                $productDetail->save();
            }

            return redirect()->route('product.list')->withInput()->with(['Success' => "Thêm dòng sản phẩm {$proDuct->name} thành công!"]);
        } catch (Exception $e) {
            return back()->withInput()->with(['error:' => "Error:" . $e->getMessage()]);
        }
    }
    public function upDate($id)
    {
        try {


            $proDuct = Product::with(['product_detail', 'product_description.front_camera', 'product_description.rear_camera', 'product_description.screen'])->find($id);


            $listBrand = Brand::where('id', '<>', $id)->get();
            $listSeries = ProductSeries::where('id', '<>', $id)->get();
            $listFrontCamera = FrontCamera::all();
            $listRearCamera = RearCamera::all();
            $listScreen = Screen::all();
            $listProductDes = ProductDescription::where('product_id', $id)->first();


            return view('product.update', compact('proDuct', 'listBrand','listSeries', 'listFrontCamera', 'listProductDes', 'listRearCamera', 'listScreen'));
        } catch (Exception $e) {
            return back()->with(['Error' => $e]);
        }
    }
    public function hdUpdate(ProductRequest $request, $id)
    {

        $proDuct = Product::find($id);
        if (!$proDuct) {
            return redirect()->route('product.list')->with(["thong_bao" => "Sản phẩm không tồn tại!"]);
        }
        $files = $request->img;
        $proDuct->name = $request->name;
        $proDuct->description = $request->description;
        $proDuct->brand_id = $request->brand;
        $proDuct->product_series_id = $request->product_series_id;
        $proDuct->save();

        $productDes = ProductDescription::where('product_id', $id)->first();
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

        if (!empty($files)) {
            $paths = [];

            foreach ($files as $file) {
                if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpg', 'png', 'jpeg'])) {
                    // Kiểm tra kích thước của từng tệp tin
                    $maxSize = 1024; // 1MB
                    if ($file->getSize() <= $maxSize * 1024) { // Chuyển đổi sang byte
                        $paths[] = $file->store('img-product');
                    } else {
                        // Kích thước hình ảnh quá lớn
                        return redirect()->back()->with(['error' => "Kích thước hình ảnh quá lớn. Vui lòng chọn hình ảnh nhỏ hơn 10MB."]);
                    }
                } else {
                    // Tệp không phải là hình ảnh
                    return redirect()->back()->with(['error' => "Tệp không phải là hình ảnh jpg, png, hoặc jpeg."]);
                }
            }

            for ($i = 0; $i < count($paths); $i++) {
                $imgProduct = new ImgProduct();
                $imgProduct->product_id = $proDuct->id;
                $imgProduct->img_url = $paths[$i];
                $imgProduct->save();
            }
        }
        return redirect()->route('product.list')->with(['Success' => "Cập nhật sản phẩm {$proDuct->ten} thành công!"]);
    }
    public function getProductDetail($id)
    {
        $listProductDetail = ProductDetail::where('product_id', $id)->get();
        $productDescription = ProductDescription::where('product_id', $id)->first();
        $proDuct = Product::find($id);
        $listImg = ImgProduct::where('product_id', $id)->get();
        return view('product.detail', compact('listProductDetail', 'proDuct', 'listImg', 'productDescription'));
    }

    public function delete($id)
    {
        $proDuct = Product::find($id);
        if (empty($proDuct)) {
            return "Sản phẩm không tồn tại";
        }
        $proDuct->delete();
        return redirect()->route('product.list')->with(['Success' => "Xóa sản phẩm {$proDuct->name} thành công!"]);
    }

    public function restore($id)
    {
        $proDuct = Product::withTrashed()->find($id);
        $proDuct->restore();
        return redirect()->route('product.list')->with(['Success' => "Phục hồi sản phẩm {$proDuct->name} thành công "]);
    }

    public function deleted($id)
    {
        $proDuct = Product::withTrashed()->find($id);
        $proDuct->forceDelete();
        return redirect()->route('product.list')->with(['Success' => "Xóa vĩnh viễn sản phẩm {$proDuct->name} thành công "]);
    }
    public function updateImg($id)
    {
        $listProductDetail = ProductDetail::where('product_id', $id)->get();
        $uniqueColors = $listProductDetail->unique('color_id');
        $listImg = ImgProduct::where('product_id', $id)->get();
        return view('product.img', compact('uniqueColors', 'id', 'listImg'));
    }
    public function hdUpdateImg(Request $request, $id)
    {
        try{

        
        $files = $request->file('img');
        $paths = [];
        
        foreach ($files as $colorId => $fileArray) {
            foreach ($fileArray as $file) {
                if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpg', 'png', 'jpeg'])) {
                    // Kiểm tra kích thước của từng tệp tin
                    $maxSize = 10240; // 10MB
                    if ($file->getSize() <= $maxSize * 1024) { // Chuyển đổi sang byte
                        $path = $file->store('img-product');
                        $paths[] = [
                            'color_id' => $colorId,
                            'path' => $path
                        ];
                    } else {
                        // Kích thước hình ảnh quá lớn
                        return redirect()->back()->with(['error' => "Kích thước hình ảnh quá lớn. Vui lòng chọn hình ảnh nhỏ hơn 10MB."]);
                    }
                } else {
                    // Tệp không phải là hình ảnh
                    return redirect()->back()->with(['error' => "Tệp không phải là hình ảnh jpg, png, hoặc jpeg."]);
                }
            }
        }

        foreach ($paths as $pathInfo) {
            $imgProduct = new ImgProduct();
            $imgProduct->product_id = $id;
            $imgProduct->color_id = $pathInfo['color_id'];
            $imgProduct->img_url = $pathInfo['path'];
            $imgProduct->save();
        }

        return redirect()->back()->with('Success', 'Cập nhật hình ảnh thành công!');
        }catch(Exception $e){
            return back()->with('Error', $e->getMessage());
        }
    }
    public function deleteImage($id)
    {
        $image = ImgProduct::findOrFail($id);
        // Xóa tệp hình ảnh khỏi hệ thống tệp nếu cần thiết
        Storage::delete($image->img_url);
        $image->delete();
        return redirect()->back()->with('success', 'Xóa hình ảnh thành công!');
    }

    public function editImage($id)
    {
        $image = ImgProduct::findOrFail($id);
        return view('product.edit_image', compact('image'));
    }
}
