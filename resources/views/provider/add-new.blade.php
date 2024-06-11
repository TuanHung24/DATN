@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h3>THÊM MỚI NHÀ CUNG CẤP</h3>
            </div>
            <form method="POST" action="{{ route('provider.hd-add-new') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Tên nhà cung cấp</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    </div>
                    @error('name')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-3">
                    <label for="phone" class="form-label">Điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                    </div>
                    @error('phone')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{old('address')}}">
                    </div>
                    @error('address')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
@endsection