@extends('master')


@section('content')

<form method="POST" action="{{route('admin.hd-reset-password')}}" enctype="multipart/form-data">
    @csrf
    <div class="profile">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4>Đổi mật khẩu</h4>
           
        </div>
        <x-notification />
        <div class="row">
            <div class="col-md-4">
                <label for="password">Nhập mật khẩu cũ:
                </label>
                <input id="password" type="password" class="form-control" name="password">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="respassword">Nhập mật khẩu mới:
                </label>
                <input id="respassword" type="password" class="form-control" name="respassword">
                @error('respassword')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="respassword1">Nhập lại mật khẩu mới:
                </label>
                <input id="respassword1" type="password" class="form-control" name="respassword1">
                @error('respassword1')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary" id="info-save-repassword">Lưu mật khẩu</button>
    </div>
</form>
@endsection