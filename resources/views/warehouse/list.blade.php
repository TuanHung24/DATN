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
<div class="d-flex justify-content-between flex-wrap flex-modal-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH NHẬP KHO</h3>
    <form action="{{ route('warehouse.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-file-import"></i>Import Excel</button>
    </form> 
</div>  
@if(session('thong_bao'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div> 
              {{session('thong_bao')}}
        </div>
    </div>
@endif
@if(session('Error'))
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <div> 
              {{session('Error')}}
        </div>
    </div>
@endif
@if(isset($listWarehouse) && $listWarehouse->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr class="title_nh">
                <th id="th-id">Mã phiếu nhập</th>
                <th>Nhà cung cấp</th>  
                <th>Tổng tiền(VND)</th>
                <th>Ngày nhập</th>
                <th>Tác vụ</th>
            </tr>
        </thead> 
        @foreach($listWarehouse as $Warehouse)
        <tr>
            <td id="td-id">NK{{ $Warehouse->id }}</td>
            <td>{{ $Warehouse->provider->name }}</td>
            <td>{{ $Warehouse->total_formatted }}</td>
            <td>{{ $Warehouse->date }}</td>
            <td class="chuc-nang">
                <a href="{{ route('warehouse.detail', ['id' => $Warehouse->id]) }}" class="btn btn-outline-info"><i class="fas fa-info-circle"></i>Chi tiết</a>
            </td>
        <tr>
            @endforeach
    </table>
</div>
@else
<span class="error">Không có phiếu nhập kho nào!</h6>
@endif
@endsection

