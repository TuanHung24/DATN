<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class APIBrandController extends Controller
{
    public function listBrand()
    {
        $listBrand = Brand::with([
            'product' => function ($query) {
                $query->whereHas('product_detail', function ($subquery) {
                    $subquery->where('quantity', '>', 0); // Filter products with quantity > 0
                });
            },
            'product.img_product',
            'product.product_detail' => function ($query) {
                $query->where('quantity', '>', 0); // Filter product details with quantity > 0
            },
            'product.product_detail.color',
            'product.product_detail.capacity',
        ])->get();
        

        return response()->json([ 
            'success' =>true,
            'data'=>$listBrand
        ]);
        
    } 
    public function layChiTiet($id)
    {
        $loaiSanPham = Brand::with([
            'san_pham' => function ($query) {
                $query->whereHas('chi_tiet_san_pham', function ($subquery) {
                    $subquery->where('so_luong', '>', 0); 
                });
            },
            'san_pham.img',
            'san_pham.chi_tiet_san_pham' => function ($query) {
                $query->where('so_luong', '>', 0); 
            },
            'san_pham.chi_tiet_san_pham.mau_sac',
            'san_pham.chi_tiet_san_pham.dung_luong',
        ])->find($id);
        
        if(empty($loaiSanPham))
        {
            return response()->json([
                'success' =>false,
                'message'=>"Loại sản phẩm ID {$id} không tồn tại"
            ]);
        }
        return response()->json([
            'success' =>true,
            'data'=>$loaiSanPham
        ]);
    }
}
