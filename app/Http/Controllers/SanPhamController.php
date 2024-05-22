<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\LoaiSanPham;
class SanPhamController extends Controller
{
    public function themMoi()
    {
        $dsLoaiSanPham=LoaiSanPham::all();
        return view('san-pham.them-moi',compact('dsLoaiSanPham'));
    }

    public function xuLyThemMoi(Request $request)
    {
        $sanPham = new SanPham();
        $sanPham->ten       = $request->ten;
        $sanPham->mo_ta          = $request->mo_ta;
        $sanPham->gia          = $request->gia;
        $sanPham->so_luong          = $request->so_luong;
        $sanPham->loai_san_pham_id      = $request->loai_san_pham;
        $sanPham->nha_cung_cap        = $request->nha_cung_cap;
        $sanPham->save();
        return "Thêm sản phẩm mới thành công";
    }

    public function danhSach()
    {
        $dsSanPham=SanPham::all();
        return view("san-pham.danh-sach", compact('dsSanPham'));
    }

    public function capNhat($id)
    {
        $dsLoaiSanPham=LoaiSanPham::all();
        $sanPham = SanPham::find($id);
        if (empty($sanPham)) {
            return "Sản phẩm không tồn tại";
        }

        return view('san-pham.cap-nhat', compact('sanPham', 'dsLoaiSanPham'));
    }

    public function xuLyCapNhat(Request $request, $id)
    {
        $sanPham = SanPham::find($id);
        if (empty($sanPham)) {
            return "Sản phẩm không tồn tại";
        }
        
        $sanPham->ten       = $request->ten;
        $sanPham->mo_ta          = $request->mo_ta;
        $sanPham->gia          = $request->gia;
        $sanPham->so_luong          = $request->so_luong;
        $sanPham->loai_san_pham_id        = $request->loai_san_pham;
        $sanPham->nha_cung_cap        = $request->nha_cung_cap;
        $sanPham->save();

        return "Cap nhat san pham thanh cong";
    }

    public function xoa($id)
    {
        $sanPham = SanPham::find($id);
        if (empty($sanPham)) {
            return "Sản phẩm không tồn tại";
        }
        
        $sanPham->delete();

        return "Xóa sản phẩm thành công";
    }
}
