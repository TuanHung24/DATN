@extends('master')

@section('page-sw')
@if(session('thong_bao'))
<script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('thong_bao')}}",
        showConfirmButton: true,
        timer: 3000
    })
</script>
@endif
@endsection

@section('content')
<form method="POST" action="{{route('admin.update-info')}}" enctype="multipart/form-data">
    @csrf
    <div class="profile">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4>Thông tin cá nhân</h4>
        </div>
        <x-notification />
        <img src="{{asset(Auth::user()->avatar_url)}}" /><br><input type="file" name="avatar" accept="image/*" placeholder="Thay đổi ảnh đại diện" />
        <p class="info-address">Chức vụ:
            <input id="info-cn" value="{{ Auth::user()->roles == 1 ? 'Quản lý' : (Auth::user()->roles == 2 ? 'Nhân viên' : (Auth::user()->roles == 3 ? 'Quản lý kho' : 'Không xác định')) }}" readonly>
        </p>


        <p class="info-username">Tên tài khoản: <input id="info-cn" value="{{old('username',Auth::user()->username)}}" readonly name="username" /><i class="fas fa-edit" id='icon-fa-edit'></i></p>
        @error('username')
        <span class="error-message">{{ $message }}</span>
        @enderror
        <p class="info-name">Họ tên: <input id="info-cn" value="{{old('name',Auth::user()->name)}}" name="name" /> <i class="fas fa-edit" id='icon-fa-edit'></i></p>
        @error('name')
        <span class="error-message">{{ $message }}</span>
        @enderror
        <p class="info-email">Email: <input id="info-cn" value="{{old('email',Auth::user()->email)}}" name="email" /><i class="fas fa-edit" id='icon-fa-edit'></i></p>
        @error('email')
        <span class="error-message">{{ $message }}</span>
        @enderror
        <p class="info-phone">Điện thoại: <input id="info-cn" value="{{old('phone',Auth::user()->phone)}}" name="phone" /><i class="fas fa-edit" id='icon-fa-edit'></i></p>
        @error('phone')
        <span class="error-message">{{ $message }}</span>
        @enderror
        <p class="info-address">Giới tính: <input id="info-cn" value="{{Auth::user()->gender == 1 ? 'Nam' : 'Nữ'}}" name="gender" readonly/><i class="fas fa-edit" id='icon-fa-edit'></i>
        <p class="info-address">Địa chỉ: <input id="info-cn" value="{{old('address',Auth::user()->address)}}" name="address" /><i class="fas fa-edit" id='icon-fa-edit'></i>
        </p>
        @error('address')
        <span class="error-message">{{ $message }}</span>
        @enderror
        <br>
        <a href="{{route('admin.reset-password')}}">Đổi Mật khẩu</a><button type="submit" class="btn btn-primary" id="info-save-cn">Lưu thông tin</button>
    </div>
</form>
@endsection