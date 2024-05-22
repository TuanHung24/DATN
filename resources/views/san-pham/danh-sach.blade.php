@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">DANH SÁCH SẢN PHẨM</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('san-pham.them-moi') }}" class="btn btn-sm btn-outline-secondary">Thêm mới</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
    <tr>
        <th>Id</td>
        <th>Tên</th>
        <th>Mô tả</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Loại sản phẩm</th>
        <th>Nhà cung cấp</th>
    </tr>
    </thead>
    @foreach($dsSanPham as $sanpham)
    <tr>
        <td>{{ $sanpham->id }}</td>
        <td>{{ $sanpham->ten }}</td>
        <td>{{ $sanpham->mo_ta }}</td>
        <td>{{ $sanpham->gia }}</td>
        <td>{{ $sanpham->so_luong }}</td>
        <td>{{ $sanpham->loai_san_pham->ten }}</td>
        <td>{{ $sanpham->nha_cung_cap }}</td>
        <td>
            <a href="{{ route('san-pham.cap-nhat', ['id' => $sanpham->id]) }}">Sửa</a> | <a href="{{ route('san-pham.xoa', ['id' => $sanpham->id]) }}">Xóa</a>
        </td>
    <tr>
    @endforeach
</table>
@endsection
</div>