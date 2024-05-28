@extends('master')


@section('page-sw')
@if(session('thong_bao'))
<script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('thong_bao')}}",
        showConfirmButton: true,
        timer: 3000
    })
</script>
@endif
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">CHI TIẾT HÓA ĐƠN</h1>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Tên sản phẩm</th>
                <th>Màu sắc</th>
                <th>Dung lượng</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
               
            </tr>
        </thead>
        @foreach($dsCTHoaDon as $cthoaDon)
        <tr>
            <td>{{ $cthoaDon->hoa_don_id }}</td>
            <td>{{ $cthoaDon->san_pham->ten }}</td>
            <td>{{ $cthoaDon->mau_sac->ten }}</td>
            <td>{{ $cthoaDon->dung_luong->ten }}</td>
            <td>{{ $cthoaDon->so_luong }}</td>
            <td>{{ $cthoaDon->don_gia_formatted }}</td>
            <td>{{ $cthoaDon->thanh_tien_formatted }}</td>
        <tr>
            @endforeach
    </table>
</div>
@endsection