@extends('master')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center border-bottom pb-2 mb-3">
        <h3>HÓA ĐƠN KHÁCH HÀNG: {{ $invoice->customer->name }}</h3>
    </div>
    <x-notification/>
    <div class="invoice mb-4">
        <div class="invoice-details mb-3">
            <p><strong>Mã hóa đơn:</strong> HD{{ $invoice->id }}</p>
            <p><strong>Khách hàng:</strong> {{ $invoice->customer->name }}</p>
            <p><strong>Điện thoại:</strong> {{ $invoice->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $invoice->address }}</p>
            
           
            <p><strong>Phương thức thanh toán:</strong> {{ $invoice->payment_method }}</p>
            <p><strong>Ngày tạo:</strong> {{ $invoice->date }}</p>

            <div class="invoice-items mb-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                       
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name }} - {{ $detail->color->name }} - {{ $detail->capacity->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($detail->into_money, 0, ',', '.') }} đ  {{$invoice->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
               
            </table>
            <p class="total-customer-main">Tổng tiền: <strong class="total-customer">{{ $invoice->total_formatted }} đ</strong> </p>
        </div>
        </div>
       
        <div class="status-bar-container mb-3">
            <div class="status-bar">
                <div class="status-step @if($invoice->status == 5) active @endif">Hủy</div>
                <div class="status-step @if($invoice->status == 1) active @endif">Chờ duyệt</div>
                <div class="status-step @if($invoice->status == 2) active @endif">Đã duyệt</div>
                <div class="status-step @if($invoice->status == 3) active @endif">Đang giao</div>
                <div class="status-step @if($invoice->status == 4) active @endif">Đã giao</div>
                <div class="status-step @if($invoice->status == 6) active @endif">Hoàn trả</div>
            </div>
        </div>
        
        <!-- <div class="actions mb-3">
            @if ($invoice->status == 1)
            <button type="button" class="btn btn-success approve-btn" data-id="{{ $invoice->id }}">Duyệt</button>
            @elseif ($invoice->status == 2)
            <a href="{{ route('invoice.update-status-delivering', ['id' => $invoice->id]) }}">
                <button type="button" class="btn btn-warning">Chuẩn bị vận chuyển</button>
            </a>
            @elseif ($invoice->status == 3)
            <a href="{{ route('invoice.update-status-complete', ['id' => $invoice->id]) }}">
                <button type="button" class="btn btn-secondary">Đang giao</button>
            </a>
            @elseif ($invoice->status == 4)
            <button type="button" class="btn btn-light">Đã giao</button>
            @elseif ($invoice->status == 5)
            <button type="button" class="btn btn-light">Đã hủy</button>
            @endif
        </div> -->
    </div>
</div>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.cancel-btn').on('click', function() {
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
