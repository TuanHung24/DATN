@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH NHÂN VIÊN</h3>
</div>


<div class="custom-search-container">
    <form action="{{ route('admin.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(isset($listAdmin) && $listAdmin->isNotEmpty($listAdmin))
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Ảnh đại diện</td>
                <th>Họ tên</th>
                <th>Email</td>
                <th>Tên tài khoản</th>
                <th>Số điện thoại</td>
                <th>Địa chỉ</th>
                <th>Giới tính</th>
                <th>Quyền</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        @foreach($listAdmin as $Admin)
        <tr>
            <td><img src="{{asset($Admin->avatar_url)}}" class="avatar1" alt="avatar" /></td>
            <td>{{ $Admin->name }}</td>
            <td>{{ $Admin->email }}</td>
            <td>{{ $Admin->username }}</td>
            <td>{{ $Admin->phone }}</td>
            <td>{{ $Admin->address }}</td>
            <td>{{ $Admin->gender == 1 ? 'Nam' : 'Nữ'}}</td>
            <td>{{ $Admin->roles == 1 ? 'Quản lý' : ($Admin->roles == 2 ? 'Nhân viên' : ($Admin->roles == 3 ? 'Quản lý kho' : 'Không xác định')) }}</td>
            <td id="td-status">
                @if ($Admin->status === 1)
                <i class="fas fa-check-circle text-success" title="Hoạt động"></i>
                @else
                <i class="fas fa-times-circle text-danger" title="Không hoạt động"></i>
                @endif
            </td>
            <td id="task">
                <a href="{{ route('admin.update', ['id' => $Admin->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> |
                @if($Admin->status === 1)
                <a href="{{ route('admin.lock', ['id' => $Admin->id]) }}" class="btn btn-outline-warning"><i class="fas fa-lock"></i></a>
                @elseif($Admin->status === 0)
                <a href="{{ route('admin.unlock', ['id' => $Admin->id]) }}" class="btn btn-outline-success"><i class="fas fa-unlock"></i></a>
                | <a href="{{ route('admin.delete', ['id' => $Admin->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                @endif
            </td>
        <tr>
            @endforeach
    </table>
    {{ $listAdmin->links('vendor.pagination.default') }}
</div>
@else
<span class="error">Không có nhân viên nào!</span>
@endif
@endsection