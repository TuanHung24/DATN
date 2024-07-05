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
    <h3>DANH SÁCH HÃNG SẢN PHẨM</h3>
    <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
        aria-controls="offcanvasRight"><i class="fa fa-trash"></i>Hãng đã xóa</button>
</div>
<div class="custom-search-container">
    <form action="{{ route('brand.search') }}" method="GET">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query ?? ''}}"
            placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />
@if(isset($listBrand) && $listBrand->isNotEmpty($listBrand))
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Tên hãng</td>
                    <th>Logo</td>
                    <th>Tác vụ</td>
                </tr>
            </thead>
            @foreach($listBrand as $Brand)
                <tr>
                    <td>{{ $Brand->name }}</td>
                    <td><img src="{{asset($Brand->img_url)}}" class="img" alt="avatar" /></td>
                    <td>
                        <a href="{{ route('brand.update', ['id' => $Brand->id]) }}" title="Cập nhật" class="btn btn-outline-primary"><i
                                class="fas fa-edit"></i></a> |
                        <a href="{{ route('brand.delete', ['id' => $Brand->id]) }}" title="Xóa" class="btn btn-outline-danger"><i
                                class="fas fa-trash"></i></a>
                    </td>
                <tr>
            @endforeach
        </table>
        {{ $listBrand->links('vendor.pagination.default') }}
    </div>
@else
    <span class="error">Không có hãng nào!</span>
@endif

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Danh sách hãng sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @if(isset($listBrandDelete) && $listBrandDelete->isNotEmpty())
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên hãng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listBrandDelete as $brandDelete)
                            <tr>
                                <td>{{$brandDelete->name}}</td>
                                <td><a href="{{ route('brand.restore', ['id' => $brandDelete->id])}}" title="Khôi phục">
                                    <i class="fas fa-undo"></i></a> | 
                                    <a href="#"><i class="fas fa-info-circle" title="Chi tiết"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @else
            <span class="error">Không có hãng nào đã xóa!</span>
        @endif
    </div>
</div>

@endsection