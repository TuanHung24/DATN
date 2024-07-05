@extends('master')


@section('page-sw')
@if(session('thong_bao'))
<script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('thong_bao')}}",
        showConfirmButton: true,
        timer: 3000
    })
</script>
@endif
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CHI TIẾT HÓA ĐƠN</h3>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Sản phẩm</th>
               
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
               
            </tr>
        </thead>
        @foreach($listInvoiceDetail as $invoiceDetail)
        <tr>
            <td>HD{{ $invoiceDetail->invoice_id }}</td>
            <td>{{ $invoiceDetail->product->name }} - {{ $invoiceDetail->color->name }} - {{ $invoiceDetail->capacity->name }}</td>
           
            <td>{{ $invoiceDetail->quantity }}</td>
            <td>{{ $invoiceDetail->price_formatted }}</td>
            <td>{{ $invoiceDetail->into_money_formatted }}</td>
        <tr>
            @endforeach
    </table>
</div>
@endsection