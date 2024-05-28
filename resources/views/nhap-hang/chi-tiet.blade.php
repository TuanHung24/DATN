@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">CHI TIẾT NHẬP HÀNG</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Mã chi tiết phiếu nhập</th>
                <th>Sản phẩm</th>
                <th>Màu sắc</th>
                <th>Dung lượng</th>
                <th>Giá nhập</th>
                <th>Giá bán</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        @foreach($dsCTPhieuNhap as $ctPhieuNhap)
        <tr>
            <td>{{ $ctPhieuNhap->id }}</td>
            <td>{{ $ctPhieuNhap->san_pham->ten }}</td>
            <td>{{ $ctPhieuNhap->mau_sac->ten }}</td>
            <td>{{ $ctPhieuNhap->dung_luong->ten }}</td>
            <td>{{ $ctPhieuNhap->gia_nhap_formatted }}</td>
            <td>{{ $ctPhieuNhap->gia_ban_formatted }}</td>
            <td>{{ $ctPhieuNhap->so_luong }}</td>
            <td>{{ $ctPhieuNhap->thanh_tien_formatted }}</td>

        <tr>
            @endforeach
    </table>
</div>
@endsection