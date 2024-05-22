@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">CẬP NHẬT LỚP</h1>
</div>
<form class="row g-3" method="POST" action="{{ route('san-pham.xl-cap-nhat', ['id' => $sanPham->id]) }}">
   @csrf
   <div class="row">
    <div class="col-md-6">
        <label for="ten" class="form-label">Tên</label>
        <input type="text" class="form-control" name="ten" value="{{$sanPham->ten}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="mo-ta" class="form-label">Mô tả</label>
        <input type="text" class="form-control" name="mo_ta" value="{{$sanPham->mo_ta}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="gia" class="form-label">Giá</label>
        <input type="text" class="form-control" name="gia" value="{{$sanPham->gia}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="so-luong" class="form-label">Số lượng</label>
        <input type="text" class="form-control" name="so_luong" value="{{$sanPham->so_luong}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="loai_san_pham" class="form-label">Loại sản phẩm</label>
        <!-- <input type="text" class="form-control" name="loai_san_pham" value="{{$sanPham->loai_san_pham->ten}}"> -->
        <select name="loai_san_pham" class="form-select">
            @foreach($dsLoaiSanPham as $loaiSanPham)
            <option value="{{$loaiSanPham->id}}">
            {{$loaiSanPham->ten}}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="nha-cung-cap" class="form-label">Nhà cung cấp</label>
        <input type="text" class="form-control" name="nha_cung_cap" value="{{$sanPham->nha_cung_cap}}">
    </div>
</div>
<div class="col-md-2">
    <button type="submit" class="btn btn-primary">Lưu</button>
  </div>

</form>
@endsection