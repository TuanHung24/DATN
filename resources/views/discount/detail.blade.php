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
    <table class="table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
               
                <th>Giá gốc</th>
                <th>Khuyến mãi(%)</th>
                <th>Giá khuyến mãi</th>
            </tr>
        </thead>
        @foreach($listDiscountDetail as $discountDetail)
        <tr>
            <td>{{ $discountDetail->product_detail->product->name }} - {{ $discountDetail->product_detail->color->name }} - {{ $discountDetail->product_detail->capacity->name }}</td>
           
            <td>{{ $discountDetail->product_detail->price_formatted }}</td>
            <td>{{ $discountDetail->percent }}</td>
            <td>{{ $discountDetail->price_formatted }}</td>
        <tr>
            @endforeach
    </table>
</div>
@endsection