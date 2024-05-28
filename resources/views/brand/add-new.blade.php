@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">THÊM MỚI HÃNG</h1>
            </div>
            <form method="POST" action="{{ route('brand.hd-add-new') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Tên Hãng</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    </div>
                    @error('name')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
@endsection