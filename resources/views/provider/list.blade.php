@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH NHÀ CUNG CẤP</h3>
</div>
<div class="custom-search-container">
    <form action="{{ route('provider.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />
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
            <td id="td-status">
                @if ($Provider->status === 1)
                <i class="fas fa-check-circle text-success" title="Hoạt động"></i>
                @else
                <i class="fas fa-times-circle text-danger" title="Không hoạt động"></i>
                @endif
            </td>
            <td>
                <a href="{{ route('provider.update', ['id' => $Provider->id]) }}" title="Cập nhật" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> |
                 <a href="{{ route('provider.delete', ['id' => $Provider->id]) }}" title="Xóa" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
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