@extends('master')




@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CHI TIẾT HÓA ĐƠN</h3>
</div>


<div class="table-responsive">
    @if($payMent)
    <h5>Thông tin thanh toán:</h5>

    
    
    <p>Mã hóa đơn: <strong> {{ $listInvoiceDetail->first()->invoice->id }}</strong></p>
    <p>Ngân hàng thanh toán: <strong> {{ $payMent->vnp_BankCode }}</strong></p>
    <p>Khách hàng: <strong> {{ $listInvoiceDetail->first()->invoice->customer->name }}</strong> </p>
    <p>Điện thoại: <strong>{{ $listInvoiceDetail->first()->invoice->phone }}</strong> </p>
    <p>Địa chỉ: <strong>{{ $listInvoiceDetail->first()->invoice->address }}</strong> </p>
    <p>Số tiền thanh toán: <strong>{{ number_format($payMent->vnp_Amount, 0, ',', '.') }}</strong> </p>
    @if($payMent->vnp_ResponseCode=='00')
    <p>Trạng thái thanh toán: <strong class="success">Thành công</strong> </p>
    @else
    <p>Trạng thái thanh toán: <strong class="error">Không thành công!</strong> </p>
    @endif
    @endif
    <table class="table">
        <thead>
            <tr>
                
                <th>Sản phẩm</th>

                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>

            </tr>
        </thead>
        @foreach($listInvoiceDetail as $invoiceDetail)
        <tr>
           
            <td>{{ $invoiceDetail->product->name }} - {{ $invoiceDetail->color->name }} - {{ $invoiceDetail->capacity->name }}</td>

            <td>{{ $invoiceDetail->quantity }}</td>
            <td>{{ $invoiceDetail->price_formatted }}</td>
            <td>{{ $invoiceDetail->into_money_formatted }}</td>
        <tr>
            @endforeach
    </table>

</div>


@endsection