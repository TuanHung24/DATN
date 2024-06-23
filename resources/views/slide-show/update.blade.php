@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT NHÂN VIÊN</h3>
</div>
@if(session('Error'))
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <div>
        {{session('Error')}}
    </div>
</div>
@endif
<form method="POST" action="{{ route('slide-show.hd-update', ['id'=> $slide->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
        <label for="product_id" class="form-label">tên sản phẩm:</label>
            <select name="product_id" class="form-select">
                <option type="text" class="form-control" name="product_id" value="{{old('product_id',$slide->product->id)}}">
                    {{$slide->product->name}}
                </option>
                @foreach($dsProduct as $product)
                <option value="{{$product->id}}">
                    {{$product->name}}
                </option>
                @endforeach
            </select>
        </div>
        @error('product_id')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class=row>
        <div class="col-md-6">
            <label for="img_url" class="form-label">Chọn ảnh: </label>
            <input type="file" name="img_url" accept="image/*"/><br />
        </div>
        @error('img_url')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
</form>
@endsection