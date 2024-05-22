@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">DANH SÁCH LOẠI SẢN PHẨM</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('loai-san-pham.them-moi') }}" class="btn btn-sm btn-outline-secondary">Thêm mới</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
    <tr>
        <th>Id</td>
        <th>Tên</th>
    </tr>
    </thead>
    @foreach($dsLoaiSanPham as $loaiSanPham)
    <tr>
        <td>{{ $loaiSanPham->id }}</td>
        <td>{{ $loaiSanPham->ten }}</td>
        <td>
            <a href="{{ route('loai-san-pham.cap-nhat', ['id' => $loaiSanPham->id]) }}">Sửa</a> | <a href="{{ route('loai-san-pham.xoa', ['id' => $loaiSanPham->id]) }}">Xóa</a>
        </td>
    <tr>
    @endforeach
</table>
@endsection
</div>