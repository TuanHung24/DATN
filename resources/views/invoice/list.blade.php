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
    <h3>DANH SÁCH HÓA ĐƠN</h3>
   
</div>  
@if(session('thong_bao'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div> 
              {{session('thong_bao')}}
        </div>
    </div>
@endif
@if(isset($listInvoice) && $listInvoice->isNotEmpty())
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr class="title_hd">
                <th id="th-id">Id</th>
                <th>Khách hàng</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Phương thức thanh toán</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        @foreach($listInvoice as $inVoice)
        <tr>
            <td id="td-id">{{$inVoice->id}}</td>
            <td>{{ $inVoice->customer->name }}</td>
            <td>{{ $inVoice->phone }}</td>
            <td>{{ $inVoice->address }}</td>
            <td>{{ $inVoice->total_formatted }}</td>
            <td>{{ $inVoice->payment_method }}</td>
            <td>{{ $inVoice->date }}</td>

            @if ($inVoice->status == 1)
            <td > 
                        <button type="button" class="btn btn-danger huy-don-btn" data-id="{{ $inVoice->id }}">Hủy</button>    
                &nbsp;
                <a href="{{route('invoice.duyet-don', ['id' => $inVoice->id])}}">
                    <button type="submit" class="btn btn-success">Duyệt</button>
                </a>
            </td>
            @elseif ($inVoice->status == 2)
                <td>
                <a href="{{route('invoice.dang-giao',['id'=> $inVoice->id])}}">
                    <button type="submit" class="btn btn-warning">Đang giao</button>
                </a>
                </td>
            @elseif ($inVoice->status == 3)
                <td>
                    <a href="{{route('invoice.hoan-thanh',['id'=> $inVoice->id])}}">
                        <button type="submit" class="btn btn-secondary">Hoàn thành</button>
                    </a>
                </td>
            @elseif ($inVoice->status == 4)
            <td>
                    <button class="btn btn-light">Đã thanh toán</button>
            </td>
            @elseif ($inVoice->status == 5)
                <td>
                        <button type="submit" class="btn btn-light">Đã hủy</button>
                </td>
            @endif



            <td class="chuc-nang">
                <a href="{{ route('invoice.chi-tiet', ['id' => $inVoice->id]) }}" class="btn btn-outline-info"><span data-feather="chevrons-right"></span></a> |
                <a href="{{ route('invoice.xoa', ['id' => $inVoice->id]) }}" class="btn btn-outline-danger"><span data-feather="trash-2"></span></a> |
                <a href="{{ route('pdf.invoice',['id' => $inVoice->id]) }}" class="btn btn-outline-secondary"><span data-feather="download"></span></a>
            </td>
        <tr>
            @endforeach
    </table>
    @if(isset($errorMessage))
        <div class="alert alert-danger">
            {{ $errorMessage }}
        </div>
    @endif
    
</div>
@else
<h6>Không có hóa đơn nào!</h6>
@endif
@endsection

