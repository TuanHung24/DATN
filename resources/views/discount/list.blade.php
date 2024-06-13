@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH KHUYẾN MÃI</h3>
</div>
@if(isset($listDiscount) && $listDiscount->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>   
                <th>Tên khuyến mãi</th>
                <th>Ngày bắt đầu</td>
                <th>Ngày kết thúc</td>
                <th>Phần trăm khuyến mãi</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        @foreach($listDiscount as $disCount)
        <tr>
            
            <td>{{ $disCount->name }}</td>
            <td>{{ $disCount->formatted_date_start  }}</td>
           
            <td>{{ $disCount->formatted_date_end }}</td>
            <td>{{ $disCount->percent }}</td>
            
            <td>{{ $disCount->status === 1 ? 'Hoạt động' : 'Không hoạt động' }}</td>
            <td>
                <a href="{{ route('discount.detail', ['id' => $disCount->id]) }}" class="btn btn-outline-primary"><i class="fas fa-info-circle"></i></a>|
                <a href="{{ route('discount.update', ['id' => $disCount->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
            </td>
        <tr>
        @endforeach
    </table>
    {{ $listDiscount->links('vendor.pagination.default') }}
</div>
@else
<sapn class="error">Không có khuyến mãi nào!</span>
@endif
@endsection