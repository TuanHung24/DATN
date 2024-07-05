@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT NHÂN VIÊN</h3>
</div>
<x-notification />
<form method="POST" action="{{ route('admin.hd-update', ['id'=> $aDmin->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT') 
    <div class="row">
        <div class="col-md-6">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $aDmin->name)}}">
        </div>
        @error('name')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" value="{{ old('email', $aDmin->email)}}">
        </div>
        @error('email')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="username" class="form-label">Tên tài khoản</label>
            <input type="text" class="form-control" name="username" value="{{ old('username', $aDmin->username)}}">
        </div>
        @error('username')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="phone" class="form-label">Điện thoại</label>
            <input type="text" class="form-control" name="phone" value="{{ old('phone', $aDmin->phone)}}">
        </div>
        @error('phone')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="address" value="{{ old('address', $aDmin->address)}}">
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
            <input type="radio" name="gender" value="1"  {{ $aDmin->gender == 1 ? 'checked' : '' }}>
            &nbsp;
            <label for="female" class="form-label">Nữ:</label>
            <input type="radio" name="gender" value="0"  {{ $aDmin->gender == 0 ? 'checked' : '' }}>
            @error('gender')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
        <div class="col-md-2" id='p-roles'>
            <label for="roles" class="form-label">Chức vụ:</label>
            <select name="roles" class="form-select" id='select-roles'>
                <option value="1" {{ $aDmin->roles == 1 ? 'selected' : '' }}>Quản lý</option>
                <option value="2" {{ $aDmin->roles == 2 ? 'selected' : '' }}>Nhân viên</option>
                <option value="3" {{ $aDmin->roles == 3 ? 'selected' : '' }}>Quản lý kho</option>
            </select>
        </div>
    </div>
    <div class=row>
        <div class="col-md-6">
            <label for="avatar" class="form-label">Chọn ảnh đại diện: </label>
            <input type="file" name="avatar" accept="image/*"/><br />
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