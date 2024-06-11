@extends('master')




@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH HÃNG SẢN PHẨM</h3>
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Thương hiệu đã xóa</button>
</div>

@if(session('Error'))
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <div> 
              {{session('Error')}}
        </div>
    </div>
@endif
@if(session('Success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div> 
              {{session('Success')}}
        </div>
    </div>
@endif
@if(isset($listBrand) && $listBrand->isNotEmpty($listBrand))
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr> 
                <th>Tên hãng</td>
                <th>Tác vụ</td>
            </tr>
        </thead>
        @foreach($listBrand as $Brand)
        <tr>
            <td>{{ $Brand->name }}</td>
            <td>
                <a href="{{ route('brand.update', ['id' => $Brand->id]) }}">Sửa</a> | <a href="{{ route('brand.delete', ['id' => $Brand->id]) }}">Xóa</a>
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
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Danh sách sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      @if(isset($listBrandDelete) && $listBrandDelete->isNotEmpty())
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($listBrandDelete as $brandDelete)
                    <tr>
                        <td>{{$brandDelete->name}}</td>
                        <td><a href="{{ route('brand.restore',['id'=>$brandDelete->id])}}">Khôi phục</a> | <a href="#">Chi tiết</a></td>
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