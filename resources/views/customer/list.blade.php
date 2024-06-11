@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH KHÁCH HÀNG</h3>
</div>
@if(isset($listCusTomer) && $listCusTomer->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>   
                <th>Họ tên</th>
                <th>Email</td>
                <th>Số điện thoại</td>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
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
    {{ $listCusTomer->links('vendor.pagination.default') }}
</div>
@else
<span class="error">Không có khách hàng nào!</span>
@endif
@endsection