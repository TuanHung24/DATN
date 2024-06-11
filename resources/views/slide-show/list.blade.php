@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH SLIDE</h3>
</div>

@if(isset($listslide) && $listslide->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Sản Phẩm</th> <!-- Đã sửa thành </th> -->
                <th>Hình ảnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listslide as $slide)
            <tr>
                <td>{{ $slide->product->name }}</td>
                <td> <img type="img_url" class="slide" name="img_url" src="{{asset($slide->img_url)}}"> </td>
            </tr> <!-- Đã thêm thẻ đóng </tr> -->
            @endforeach
        </tbody>
    </table>
</div>
@else
    <span class="error">Không có tin tức nào!</span>
@endif
@endsection
