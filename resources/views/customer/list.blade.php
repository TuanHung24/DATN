@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH KHÁCH HÀNG</h3>
</div>
<div class="custom-search-container">
    <form action="{{ route('customer.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />
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
            <td id="td-status">
                @if ($cusTomer->status === 1)
                <i class="fas fa-check-circle text-success" title="Hoạt động"></i>
                @else
                <i class="fas fa-times-circle text-danger" title="Không hoạt động"></i>
                @endif
            </td>
            
            <td>
                <a href="{{ route('customer.get-invoice', ['id'=> $cusTomer->id ]) }}" class="btn btn-outline-info"><i class="fas fa-info-circle"></i></a> |
                <a href="{{ route('customer.update', ['id' => $cusTomer->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> | 
                @if($cusTomer->status === 1)
                <a href="{{ route('customer.lock', ['id' => $cusTomer->id]) }}" class="btn btn-outline-warning"><i class="fas fa-lock"></i></a>
                @elseif($cusTomer->status === 0)
                    <a href="{{ route('customer.unlock', ['id' => $cusTomer->id]) }}" class="btn btn-outline-success"><i class="fas fa-unlock"></i></a>
                |  <a href="{{ route('customer.delete', ['id' => $cusTomer->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                @endif
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