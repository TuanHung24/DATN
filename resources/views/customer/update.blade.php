@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h3>THÊM MỚI KHÁCH HÀNG</h3>
            </div>
            <form method="POST" action="{{ route('customer.hd-update', ['id'=> $cusTomer->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $cusTomer->name)}}">
                    </div>
                    @error('name')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email', $cusTomer->email)}}">
                    </div>
                    @error('email')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label for="phone" class="form-label">Điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $cusTomer->phone)}}">
                    </div>
                    @error('phone')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address', $cusTomer->address)}}">
                    </div>
                    @error('address')
                        <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="row"> 
                    <div class="col-md-6">
                        <label for="status" class="form-label">Trạng thái</label>
                        <input type="checkbox" name="status" {{ old('status', $cusTomer->status) ? 'checked' : '' }}/>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
@endsection