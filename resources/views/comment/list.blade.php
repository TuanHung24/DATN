@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH BÌNH LUẬN</h3>
</div>
<div class="custom-search-container">
    <form action="{{ route('comment.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />
@if(isset($listComment) && $listComment->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Sản Phẩm</th>
                <th>Bình luận</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listComment as $Comment)
            <tr>
                <td>
                    <img src="{{ asset($Comment->product->img_url) }}" class="product-image" />
                    <div class="product-name">{{ $Comment->product->name }}</div>
                </td>
                <td class="comment-container">
                    <div class="comment-label">Khách hàng:</div>
                    <strong class="comment-author">{{ $Comment->customer->name }}</strong>
                    <div class="comment-label">Nội dung:</div>
                    <div class="comment-content">{{ $Comment->content }}</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $listComment->links('vendor.pagination.default') }}
</div>
@else
<span class="error">Không có bình luận nào!</span>
@endif
@endsection