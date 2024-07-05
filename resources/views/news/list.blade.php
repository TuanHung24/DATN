@extends('master')

@section('content')

<head>
    <style>
        img {
            height: 100px;
        }
    </style>
</head>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH TIN TỨC</h3>
</div>
<div class="custom-search-container">
    <form action="{{ route('news.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query ?? ''}}"
            placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />
@if(isset($listNews) && $listNews->isNotEmpty())
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Ảnh nền</th>
                    <th>Tác giả</th>
                    <th>Title</th>
                    
                   
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listNews as $News)
                    <tr>
                        <td><img src="{{asset($News->img_url)}}" class="img" alt="avatar" /></td>
                        <td>{{ $News->admin->name }}</td>
                        <td>{{ $News->title }}</td>
                        <td>
                            <a href="{{ route('news.update', ['id' => $News->id]) }}" title="Cập nhật" class="btn btn-outline-primary"><i
                                    class="fas fa-edit"></i></a> |
                            <a href="{{ route('news.delete', ['id' => $News->id]) }}" title="Xóa" class="btn btn-outline-danger"><i
                                    class="fas fa-trash"></i></a>
                        </td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
        {{ $listNews->links('vendor.pagination.default') }}
    </div>
@else
    <span class="error">Không có tin tức nào!</span>
@endif
@endsection