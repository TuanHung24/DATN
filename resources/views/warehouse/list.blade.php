@extends('master')


@section('page-sw')
@if(session('don_hang'))
<script>
        Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('don_hang')}}",
        showConfirmButton: true,
        timer: 9000
        })
    </script>
@endif
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH NHẬP KHO</h3>
   
</div>  
@if(session('thong_bao'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div> 
              {{session('thong_bao')}}
        </div>
    </div>
@endif
@if(isset($listWarehouse) && $listWarehouse->isNotEmpty())
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr class="title_nh">
                <th id="th-id">Mã phiếu nhập</th>
                <th>Nhà cung cấp</th>  
                <th>Tổng tiền(VND)</th>
                <th>Ngày nhập</th>
                <th>Thao tác</th>
            </tr>
        </thead> 
        @foreach($listWarehouse as $Warehouse)
        <tr>
            <td id="td-id">{{ $Warehouse->id }}</td>
            <td>{{ $Warehouse->provider->name }}</td>
            <td>{{ $Warehouse->total_formatted }}</td>
            <td>{{ $Warehouse->date }}</td>
            <td class="chuc-nang">
                <a href="{{ route('warehouse.detail', ['id' => $Warehouse->id]) }}" class="btn btn-outline-info"><span data-feather="chevrons-right"></span>Chi tiết</a>
            </td>
        <tr>
            @endforeach
    </table>
</div>
@else
<h6>Không có hóa đơn nào!</h6>
@endif
@endsection

