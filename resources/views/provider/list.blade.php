@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 >DANH SÁCH NHÀ CUNG CẤP</h3>
</div>
@if(isset($listProvider) && $listProvider->isNotEmpty($listProvider))
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr> 
                <th>Tên nhà cung cấp</td>
                <th>Số điện thoại</th>
                <th>Điện thoại</td>
                <th>Trạng thái</th>
            </tr>
        </thead>
        @foreach($listProvider as $Provider)
        <tr>
            <td>{{ $Provider->name }}</td>
            <td>{{ $Provider->address }}</td>
            <td>{{ $Provider->phone }}</td>
            <td>{{ $Provider->status === 1 ? 'Hoạt động' : 'Không hoạt động' }}</td>
            <td>
                <!-- <a href="{{ route('admin.update', ['id' => $Provider->id]) }}">Sửa</a> | <a href="{{ route('admin.delete', ['id' => $Provider->id]) }}">Xóa</a> -->
            </td>
        <tr>
        @endforeach
    </table>
</div>
@else
<h6>Không có nhà cung cấp nào!</h6>
@endif
@endsection