<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class APIProductController extends Controller
{
    public function listProduct()
    {

        $listProduct = Product::whereHas('product_detail', function ($query) {

            $query->where('quantity', '>', 0);
        })
            ->with([
                'brand',
                'img_product',
                'product_series',
                'rate',
                'product_description',
                'product_detail.color',
                'product_detail.capacity',
                'product_detail.discount_detail' => function ($query) {
                    $query->isActive();
                }
            ])
            ->get();


        return response()->json([
            'success' => true,
            'data' => $listProduct
        ]);
    }
    public function getProductDetail($name)
    {
        
            $product = Product::where('name', $name)
                ->whereHas('product_detail', function ($query) {
                    $query->where('quantity', '>', 0);
                })
                ->with([
                    'product_description.front_camera',
                    'product_description.rear_camera',
                    'product_description.screen',
                    'rate',
                    'comment.customer:id,name',
                    'comment.comment_detail.admin:id,name',
                    'brand',
                    'product_series',
                    'img_product',
                    'product_detail.color',
                    'product_detail.capacity',
                    'product_detail.discount_detail' => function ($query) {
                        $query->isActive()->with(['discount:id,date_start,date_end']);
                    }
                ])
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $product
            ]);
       
    }


    public function timKiem(Request $request)
    {
        $proDuct = Product::with(['brand', 'product_series'])->where('name', $request->name)->first();
        if (empty($proDuct)) {
            return response()->json([
                'success' => false,
                'message' => "Sản phẩm tên {$request->name} không tồn tại"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $proDuct
        ]);
    }
    public function timKiemTen($searchTerm)
    {
        $name = $searchTerm;
        $proDuct = Product::with([
            'brand',
            'product_series',
            'img',
            'product_detail' => function ($query) {
                $query->with('color', 'capacity');
            }
        ])->where('name', 'like', '%' . $name . '%')->get();
        if ($proDuct->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "Sản phẩm không tồn tại"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $proDuct
        ]);
    }
    public function setPrice($searchTerm, $priceRange)
    {
        $name = $searchTerm;
        list($priceMin, $priceMax) = explode('-', $priceRange);

        $productDetail = ProductDetail::with([
            'img_product',
            'color',
            'capacity',
            'product' => function ($query) use ($name) {
                $query->select('id', 'name')->where('name', 'like', '%' . $name . '%');
            }
        ])->whereBetween('price', [(int)$priceMin, (int)$priceMax])->get();

        if ($productDetail->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "Sản phẩm không tồn tại"
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $productDetail
        ]);
    }
}
