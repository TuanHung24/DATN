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
    <h3>CHI TIẾT KHO</h3>
</div>
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Tên sản phẩm</th>
                <th>Màu sắc</th>
                <th>Dung lượng</th>
                <th>Số lượng</th>
                <th>Giá nhập</th>
                <th>Giá bán</th>
                <th>Thành tiền</th>
               
            </tr>
        </thead>
        @foreach($listWareHouseDetail as $wareHouseDetail)
        <tr>
            <td>{{ $wareHouseDetail->warehouse_id }}</td>
            <td>{{ $wareHouseDetail->product->name }}</td>
            <td>{{ $wareHouseDetail->color->name }}</td>
            <td>{{ $wareHouseDetail->capacity->name }}</td>
            
            <td>{{ $wareHouseDetail->quanlity }}</td>
            <td>{{ $wareHouseDetail->in_price_formatted }}</td>
            <td>{{ $wareHouseDetail->out_price_formatted }}</td>
            <td>{{ $wareHouseDetail->into_money_formatted }}</td>
        <tr>
            @endforeach
    </table>
</div>
@endsection