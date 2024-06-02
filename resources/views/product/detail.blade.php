@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CHI TIẾT SẢN PHẨM: {{$proDuct->name}}</h3>
</div>
@if(isset($listProductDetail) && $listProductDetail->isNotEmpty())
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
    <tr class="title_sp">
        <th>Màu sắc</th>
        <th>Dung lượng</th>  
        <th>Giá bán</th>
        <th>Số lượng tồn</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listProductDetail as $productDetail)
    <tr>
        <td>{{ $productDetail->color->name }}</td>
        <td>{{ $productDetail->capacity->name }}</td>
        <td>{{ $productDetail->price }}</td>
        <td>{{ $productDetail->quanlity }}</td>
    <tr>
    @endforeach
    </tbody>
</table> 
@else
    <h6>Không có sản phẩm nào!</h6>
@endif
@endsection
