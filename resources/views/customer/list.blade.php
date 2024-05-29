@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH KHÁCH HÀNG</h3>
</div>
@if(isset($listCusTomer) && $listCusTomer->isNotEmpty())
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr>   
                <th>Họ tên</th>
                <th>Email</td>
                <th>Số điện thoại</td>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        @foreach($listCusTomer as $cusTomer)
        <tr>
            
            <td>{{ $cusTomer->name }}</td>
            <td>{{ $cusTomer->email }}</td>
           
            <td>{{ $cusTomer->phone }}</td>
            <td>{{ $cusTomer->address }}</td>
            
            <td>{{ $cusTomer->status === 1 ? 'Hoạt động' : 'Không hoạt động' }}</td>
            <td>
                <a href="{{ route('customer.update', ['id' => $cusTomer->id]) }}">Sửa</a> | <a href="{{ route('customer.delete', ['id' => $cusTomer->id]) }}">Xóa</a>
            </td>
        <tr>
        @endforeach
    </table>
</div>
@else
<h6>Không có nhân viên nào!</h6>
@endif
@endsection