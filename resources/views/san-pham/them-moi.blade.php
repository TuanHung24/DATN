@extends('master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3 mb-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">THÊM MỚI SẢN PHẨM</h1>
            </div>
            <form method="POST" action="{{ route('san-pham.xl-them-moi') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="ten" class="form-label">Tên</label>
                        <input type="text" class="form-control" name="ten">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="mo-ta" class="form-label">Mô tả</label>
                        <input type="text" class="form-control" name="mo_ta">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="gia" class="form-label">Giá</label>
                        <input type="text" class="form-control" name="gia">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="so-luong" class="form-label">Số lượng</label>
                        <input type="text" class="form-control" name="so_luong">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="loai-san-pham" class="form-label">Loại sản phẩm</label>
                        <select name="loai_san_pham" class="form-select">
                            @foreach($dsLoaiSanPham as $LoaiSanPham)
                            <option value="{{$LoaiSanPham->id}}">{{$LoaiSanPham->ten}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="nha-cung-cap" class="form-label">Nhà cung cấp</label>
                        <input type="text" class="form-control" name="nha_cung_cap">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection