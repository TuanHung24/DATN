@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">THÊM MỚI NHÂN VIÊN</h1>
            </div>
            <form method="POST" action="{{ route('admin.hd-update', ['id'=> $aDmin->id]) }}" enctype="multipart/form-data">
                @csrf
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
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" name="password" value="{{ old('password', $aDmin->password)}}">
                    </div>
                    @error('password')
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
                <div class="row">
                    <div class="col-md-6">
                        <label for="roles" class="form-label">Chức vụ:</label>
                        <select id="roles" name="roles" class="form-control">
                            <option value="1" {{ $aDmin->roles == 1 ? 'selected' : '' }}>Quản lý</option>
                            <option value="2" {{ $aDmin->roles == 2 ? 'selected' : '' }}>Nhân viên</option>
                            <option value="3" {{ $aDmin->roles == 3 ? 'selected' : '' }}>Quản lý kho</option>
                        </select>
                    </div>
                </div>
                <div class=row>
                    <div class="col-md-6">
                    <label for="avatar" class="form-label">Chọn ảnh: </label>
                    <input type="file" name="avatar"/><br/>
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