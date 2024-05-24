@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">THÊM MỚI SẢN PHẨM</h1>
            </div>
            <form method="POST" action="{{ route('admin.hd-add-new') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Tên tài khoản</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label for="phone" class="form-label">Điện thoại</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label for="khach-hang" class="form-label" name="roles">Chức vụ:</label>
                        <select>
                            <option selected disabled>Chọn chức vụ</option>
                            <option value="1">Quản lý</option>
                            <option value="2">Nhân viên</option>
                            <option value="3">Quản lý kho</option>
                        </select>
                    </div>
                </div>
                <div class=row>
                    <div class="col-md-6">
                    <label for="avatar" class="form-label">Chọn ảnh: </label>
                    <input type="file" name="avatar" required/><br/>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
@endsection