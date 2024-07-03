@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH HÓA ĐƠN</h3>
</div>
<div class="custom-search-container">
    <form action="{{ route('invoice.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification/>
@if(isset($listInvoice) && $listInvoice->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr class="title_hd">
                <th>MAHD</th>
                <th>Khách hàng</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>PT thanh toán</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        @foreach($listInvoice as $inVoice)
        <tr>
            <td>HD{{$inVoice->id}}</td>
            <td>{{ $inVoice->customer->name }}</td>
            <td>{{ $inVoice->phone }}</td>
            <td>{{ $inVoice->address }}</td>
            <td>{{ $inVoice->total_formatted }}</td>
            <td>{{ $inVoice->payment_method }}</td>
            <td>{{ \Carbon\Carbon::parse($inVoice->date)->format('d/m/Y H:i') }}</td>
            <td class="status">
            @if ($inVoice->status == 1)
            
                <button type="button" class="btn btn-danger cancel-btn" data-id="{{ $inVoice->id }}">Hủy</button>
                &nbsp;
                <a href="{{route('invoice.update-status-approved', ['id' => $inVoice->id])}}">
                    <button type="submit" class="btn btn-success">Duyệt</button>
                </a>
            
            @elseif ($inVoice->status == 2)
           
                <a href="{{route('invoice.update-status-delivering',['id'=> $inVoice->id])}}">
                    <button type="submit" class="btn btn-warning">Đang vận chuyển</button>
                </a>
            
            @elseif ($inVoice->status == 3)
            
                <a href="{{route('invoice.update-status-complete',['id'=> $inVoice->id])}}">
                    <button type="submit" class="btn btn-secondary">Đã giao</button>
                </a>
           
            @elseif ($inVoice->status == 4)
            
                <button class="btn btn-light">Hoàn thành</button>
            
            @elseif ($inVoice->status == 5)
            
                <button type="submit" class="btn btn-light">Đã hủy</button>
            
            @endif
            </td>
            <td class="chuc-nang">
                <a href="{{ route('invoice.detail', ['id'=> $inVoice->id ]) }}" class="btn btn-outline-info"><i class="fas fa-info-circle"></i>Chi tiết</a>
                <a href="{{ route('invoice.export', ['id'=> $inVoice->id ]) }}" class="btn btn-outline-success"><i class="fas fa-file-export"></i>PDF</a>
            </td>
        <tr>
            @endforeach
    </table>
    @if(isset($errorMessage))
    <div class="alert alert-danger">
        {{ $errorMessage }}
    </div>
    @endif

    {{ $listInvoice->links('vendor.pagination.default') }}
</div>
@else
<span class="error">Không có hóa đơn nào!</h6>
@endif
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function(){

        $('.cancel-btn').on('click', function(){
        var invoiceId = $(this).data('id');
        var confirmHuy = false; 

        if (!confirmHuy) {
            var confirmXoa = confirm("Bạn chắc chắn có muốn hủy hóa đơn này không?");

            if (confirmXoa) {
                window.location.href = "{{ route('invoice.update-status-cancel', '') }}/" + invoiceId;
            } else {
                window.location.href = "{{ route('invoice.list') }}";
            }
        }
    
    });
    });
</script>
@endsection