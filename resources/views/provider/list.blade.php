@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH NHÀ CUNG CẤP</h3>
</div>
@if(isset($listProvider) && $listProvider->isNotEmpty($listProvider))
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr> 
                <th>Tên nhà cung cấp</td>
                <th>Địa chỉ</th>
                <th>Điện thoại</td>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        @foreach($listProvider as $Provider)
        <tr>
            <td>{{ $Provider->name }}</td>
            <td>{{ $Provider->address }}</td>
            <td>{{ $Provider->phone }}</td>
            <td>{{ $Provider->status === 1 ? 'Hoạt động' : 'Không hoạt động' }}</td>
            <td>
                <a href="{{ route('provider.update', ['id' => $Provider->id]) }}">Sửa</a> | <a href="{{ route('provider.delete', ['id' => $Provider->id]) }}">Xóa</a>
            </td>
        <tr>
        @endforeach
    </table>
    {{ $listProvider->links('vendor.pagination.default') }}
</div>
@else
<span class="error">Không có nhà cung cấp nào!</span>
@endif
@endsection