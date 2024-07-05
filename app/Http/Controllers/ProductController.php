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

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            $listProduct = Product::where('name', 'like', '%' . $query . '%')
                ->paginate(9);
            if ($request->ajax()) {
                $view = view('product.table', compact('listProduct'))->render();
                return response()->json(['html' => $view]);
            }
            return view('product.list', compact('listProduct', 'query'));
        } catch (Exception $e) {
            return back()->with(['Error' => 'Không tìm thấy sản phẩm']);
        }
    }
    public function getList()
    {
        $listProduct = Product::paginate(9);
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
        return view('product.add-new', compact('listBrand', 'listSeries', 'listFrontCamera', 'listRearCamera', 'listScreen', 'listColors', 'listCapacity'));
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


            $proDuct = Product::with(['product_detail', 'product_description.front_camera', 'product_description.rear_camera', 'product_description.screen'])->findOrFail($id);


            $listBrand = Brand::where('id', '<>', $id)->get();
            $listSeries = ProductSeries::where('id', '<>', $id)->get();
            $listFrontCamera = FrontCamera::all();
            $listRearCamera = RearCamera::all();
            $listScreen = Screen::all();
            $listColors = Color::all();
            $listCapacity = Capacity::all();
            $listProductDes = ProductDescription::where('product_id', $id)->first();


            return view('product.update', compact('proDuct', 'listBrand', 'listSeries', 'listFrontCamera', 'listProductDes', 'listRearCamera', 'listScreen', 'listColors', 'listCapacity'));
        } catch (Exception $e) {
            return back()->with(['Error' => $e]);
        }
    }
    public function hdUpdate(ProductRequest $request, $id)
    {
        try {


            $proDuct = Product::findOrFail($id);
            if (!$proDuct) {
                return redirect()->route('product.list')->with(["Error" => "Sản phẩm không tồn tại!"]);
            }

            $proDuct->name = $request->name;
            $proDuct->description = $request->description;
            $proDuct->brand_id = $request->brand_id;
            $proDuct->product_series_id = $request->product_series_id;
            $proDuct->save();

            $productDes = ProductDescription::where('product_id', $proDuct->id)->first();
            $productDes->product_id = $proDuct->id;
            $productDes->front_camera_id = $request->front_camera;
            $productDes->rear_camera_id = $request->rear_camera;
            $productDes->screen_id = $request->size_screen;
            $productDes->weight = $request->weight;
            $productDes->os = $request->os;
            $productDes->battery = $request->battery;
            $productDes->ram = $request->ram;
            $productDes->chip = $request->chip;
            $productDes->sims = $request->sims;
            $productDes->save();



            return redirect()->route('product.list')->with(['Success' => "Cập nhật sản phẩm {$proDuct->name} thành công!"]);
        } catch (Exception $e) {
            return back()->withInput();
        }
    }
    public function getProductDetail($id)
    {
        try {


            $listProductDetail = ProductDetail::where('product_id', $id)->get();
            $productDescription = ProductDescription::where('product_id', $id)->first();
            $proDuct = Product::findOrFail($id);
            $listImg = ImgProduct::where('product_id', $id)->get();
            return view('product.detail', compact('listProductDetail', 'proDuct', 'listImg', 'productDescription'));
        } catch (Exception $e) {
            return back()->with(['Error' => 'Không tìm thấy chi tiết sản phẩm!']);
        }
    }

    public function delete($id)
    {
        $proDuct = Product::findOrFail($id);
        $proDuct->delete();
        return redirect()->route('product.list')->with(['Success' => "Xóa sản phẩm {$proDuct->name} thành công!"]);
    }

    public function restore($id)
    {
        $proDuct = Product::withTrashed()->findOrFail($id);
        $proDuct->restore();
        return redirect()->route('product.list')->with(['Success' => "Phục hồi sản phẩm {$proDuct->name} thành công "]);
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
        try {


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
        } catch (Exception $e) {
            return back()->with('Error', 'Thêm ảnh không thành công');
        }
    }
    public function deleteImage($id)
    {
        $image = ImgProduct::findOrFail($id);
        $image->delete();
        return redirect()->back()->with('success', 'Xóa hình ảnh thành công!');
    }

    public function updateImage(Request $request, $id)
    {
        try {
            $image = ImgProduct::findOrFail($id);
            $file = $request->file('img');

            if ($file) {
                if ($image->img_url) {
                    Storage::delete($image->img_url);
                }

                $path = $file->store('img-product');
                $image->img_url = $path;
                $image->save();
                return redirect()->back()->with('Success', 'Cập nhật hình ảnh thành công!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('Error', 'Không thể cập nhật hình ảnh.');
        }
    }

    public function editImage($id)
    {
        $image = ImgProduct::findOrFail($id);
        return view('product.edit_image', compact('image'));
    }
    public function deleteDetail($id)
    {

        $productDetail = ProductDetail::where('quantity', '<=', 0)
            ->orWhereNull('quantity')
            ->where('id', $id)
            ->first();

        if (!$productDetail) {
            return response()->json(['Error' => 'Chi tiết sản phẩm không tồn tại!'], 404);
        }


        $countProductDetail = ProductDetail::where('product_id', $productDetail->product_id)
            ->where('color_id', $productDetail->color_id)
            ->count();


        if ($countProductDetail <= 1) {

            $imgProduct = ImgProduct::where('product_id', $productDetail->product_id)
                ->where('color_id', $productDetail->color_id)
                ->first();


            if ($imgProduct) {

                $filePath = public_path($imgProduct->img_url);


                if (file_exists($filePath)) {
                    unlink($filePath);
                }


                $imgProduct->delete();
            }
        }


        $productDetail->delete();

        return response()->json(['Success' => true]);
    }
    public function addDetail(Request $request, $productId)
    {

        $colors = $request->input('colors');
        $capacities = $request->input('capacities');

        $exists = ProductDetail::where('product_id', $productId)
            ->where('color_id', $colors)
            ->where('capacity_id', $capacities)
            ->exists();

        if ($exists) {
            return response()->json(['Success' => false, 'Message' => 'Màu sắc và dung lượng này đã tồn tại.']);
        }


        $productDetail = new ProductDetail();
        $productDetail->product_id = $productId;
        $productDetail->color_id = $colors;
        $productDetail->capacity_id = $capacities;
        $productDetail->quantity = 0;
        $productDetail->price = 0;
        $productDetail->save();


        return response()->json(['Success' => true]);
    }
}
