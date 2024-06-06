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
    <h3>CHI TIẾT KHUYẾN MÃI</h3>
</div>
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Màu sắc</th>
                <th>Dung lượng</th>
                <th>Giá gốc</th>
                <th>Khuyến mãi(%)</th>
                <th>Giá khuyến mãi</th>
            </tr>
        </thead>
        @foreach($listDiscountDetail as $discountDetail)
        <tr>
            <td>{{ $discountDetail->product_detail->product->name }}</td>
            <td>{{ $discountDetail->product_detail->color->name }}</td>
            <td>{{ $discountDetail->product_detail->capacity->name }}</td>
            <td>{{ $discountDetail->product_detail->price_formatted }}</td>
            <td>{{ $discountDetail->percent }}</td>
            <td>{{ $discountDetail->price_formatted }}</td>
        <tr>
            @endforeach
    </table>
</div>
@endsection