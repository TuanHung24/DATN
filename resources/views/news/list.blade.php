@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH TIN TỨC</h3>
</div>
<div class="custom-search-container">
    <form action="{{ route('news.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification/>
@if(isset($listNews) && $listNews->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Tác giả</th>
                <th>Title</th> <!-- Đã sửa thành </th> -->
                <th>Nội dung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listNews as $News)
            <tr>
                <td>{{ $News->admin->name }}</td>
                <td>{{ $News->title }}</td>
                <td>{!! $News->content !!}</td>
                <td>
                <a href="{{ route('news.update', ['id' => $News->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> |
                <a href="{{ route('news.delete', ['id' => $News->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                </td>
            </tr> <!-- Đã thêm thẻ đóng </tr> -->
            @endforeach
        </tbody>
    </table>
    {{ $listNews->links('vendor.pagination.default') }}
</div>
@else
    <span class="error">Không có tin tức nào!</span>
@endif
@endsection
