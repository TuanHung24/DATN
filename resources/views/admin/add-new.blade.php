@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>THÊM MỚI NHÂN VIÊN</h3>
</div>
@if(session('Error'))
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <div>
        {{session('Error')}}
    </div>
</div>
@endif
<form method="POST" action="{{ route('admin.hd-add-new') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
        </div>
        @error('name')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" value="{{old('email')}}">
        </div>
        @error('email')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-2">
            <label for="username" class="form-label">Tên tài khoản</label>
            <input type="text" class="form-control" name="username" value="{{old('username')}}">
        </div>
        @error('username')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="password" value="{{old('password')}}">
        </div>
        @error('password')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-2">
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
    <br />
    <div class="row">
        <div class="col-md-3">
            <label for="gender" class="form-label">Giới tính:</label>
            &nbsp;
            <label for="male" class="form-label">Nam:</label>
            <input type="radio" name="gender" value="1" checked>
            &nbsp;
            <label for="female" class="form-label">Nữ:</label>
            <input type="radio" name="gender" value="0">
            @error('gender')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
        <div class="col-md-2" id='p-roles'>
            <label for="roles" class="form-label">Chức vụ:</label>
            <select name="roles" class="form-select" id='select-roles'>
                <option selected disabled>Chọn chức vụ</option>
                <option value="1">Quản lý</option>
                <option value="2" selected>Nhân viên</option>
                <option value="3">Quản lý kho</option>
            </select>
            @error('roles')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
    </div>
    <div class=row>
        <div class="col-md-6">
            <label for="avatar" class="form-label">Chọn ảnh: </label>
            <input type="file" name="avatar" required /><br />
        </div>
        @error('avatar')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
</form>
@endsection