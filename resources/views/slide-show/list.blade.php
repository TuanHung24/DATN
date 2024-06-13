@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH SLIDE</h3>
</div>

@if(isset($listSlide) && $listSlide->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th id='th-sp'>Sản Phẩm</th>
                <th>Hình ảnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listSlide as $slide)
            <tr>
                <td>{{ $slide->product->name }}</td>
                <td> <img type="img_url" class="slide" name="img_url" src="{{asset($slide->img_url)}}"> </td>
                <td>
                <a href="{{ route('slide-show.update', ['id' => $slide->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> | 
                <a href="{{ route('slide-show.delete', ['id' => $slide->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $listSlide->links('vendor.pagination.default') }}
</div>
@else
    <span class="error">Không có Slideshow nào!</span>
@endif
@endsection
