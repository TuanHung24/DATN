@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>THÊM MỚI HÃNG SẢN PHẨM</h3>
</div>
<form method="POST" action="{{ route('brand.hd-update', ['id' => $bRand->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label for="name" class="form-label">Tên Hãng</label>
            <input type="text" class="form-control" name="name" value="{{old('name', $bRand->name)}}">
        </div>
        @error('name')
            <span class="error-message"> {{ $message }} </span>
        @enderror
        <div class="col-md-6">
            <label for="img_url" class="form-label">Chọn Logo </label>
            <input type="file" name="img_url" value="{{old('img_url', $bRand->img_url)}}" accept="image/*"
                required /><br />
        </div>
        @error('img_url')
            <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </div>
</form>
@endsection