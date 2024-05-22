<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiSanPham;

class LoaiSanPhamController extends Controller
{
    public function themMoi()
    {
        return view('loai-san-pham.them-moi');
    }

    public function xuLyThemMoi(Request $request)
    {
        $loaiSanPham = new LoaiSanPham();
        $loaiSanPham->ten       = $request->ten;
        $loaiSanPham->save();
        return "Thêm loại sản phẩm mới thành công";
    }

    public function danhSach()
    {
        $dsLoaiSanPham=LoaiSanPham::all();
        return view("loai-san-pham.danh-sach", compact('dsLoaiSanPham'));
    }

    public function capNhat($id)
    {
        
        $loaiSanPham = LoaiSanPham::find($id);
        if (empty($loaiSanPham)) {
            return "Loại sản phẩm không tồn tại";
        }

        return view('loai-san-pham.cap-nhat', compact('loaiSanPham'));
    }

    public function xuLyCapNhat(Request $request, $id)
    {
        $loaiSanPham = LoaiSanPham::find($id);
        if (empty($loaiSanPham)) {
            return "Loại sản phẩm không tồn tại";
        }
        
        $loaiSanPham->ten       = $request->ten;
        $loaiSanPham->save();

        return "Cập nhật loại sản phẩm thành công";
    }

    public function xoa($id)
    {
        $loaiSanPham = LoaiSanPham::find($id);
        if (empty($loaiSanPham)) {
            return "Sản phẩm không tồn tại";
        }
        
        $loaiSanPham->delete();
        return "Xóa sản phẩm thành công";
    }
}
