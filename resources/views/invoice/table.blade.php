@if(isset($listInvoice) && $listInvoice->isNotEmpty())
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
            <th>TT hiện tại</th>
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
        <td class="status-now">
            @if ($inVoice->status == 1)
                <button type="submit" class="btn btn-primary">Chờ duyệt</button>
            @elseif($inVoice->status == 2)
                <button type="submit" class="btn btn-primary">Đã duyệt</button>
            @elseif($inVoice->status == 3)
                <button type="submit" class="btn btn-primary">Đang giao</button>
            @elseif($inVoice->status == 4)
            <button type="submit" class="btn btn-primary">Đã giao</button>
            @elseif($inVoice->status == 5)
            <button type="submit" class="btn btn-primary">Đã hủy</button>
            @else
            <button type="submit" class="btn btn-primary">Hoàn trả</button>
            @endif
        </td>
        <td class="status">
            @if ($inVoice->status == 1)
            <button type="button" class="btn btn-danger cancel-btn" data-id="{{ $inVoice->id }}">Hủy</button>
            &nbsp;
            <a href="{{route('invoice.update-status-approved', ['id' => $inVoice->id])}}">
                <button type="submit" class="btn btn-success">Duyệt</button>
            </a>
            @elseif ($inVoice->status == 2)
            <a href="{{route('invoice.update-status-delivering',['id'=> $inVoice->id])}}">
                <button type="submit" class="btn btn-warning">Đang giao</button>
            </a>
            @elseif ($inVoice->status == 3)
            <a href="{{route('invoice.update-status-complete',['id'=> $inVoice->id])}}">
                <button type="submit" class="btn btn-secondary">Đã giao</button>
            </a>
            @elseif ($inVoice->status == 4)
            <button class="btn btn-light">Đã giao</button>
            @elseif ($inVoice->status == 5)
            <button type="submit" class="btn btn-light">Đã hủy</button>
            @elseif ($inVoice->status == 6)
            <button type="submit" class="btn btn-info">Hoàn trả</button>
            @endif
        </td>
        <td class="chuc-nang-invoice">
            <a href="{{ route('invoice.detail', ['id'=> $inVoice->id ]) }}" class="btn btn-outline-info" title="Chi tiết"><i class="fas fa-info-circle"></i></a>
            <a href="{{ route('invoice.export', ['id'=> $inVoice->id ]) }}" class="btn btn-outline-success" title="Xuất PDF"><i class="fas fa-file-export"></i>PDF</a>
            
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
@else
<span class="error">Không có hóa đơn nào!</h6>
@endif