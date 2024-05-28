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
    <h4><span data-feather="list" ></span>DANH SÁCH HÓA ĐƠN</h4>
    <!-- <form action="{{route('invoice.tim-kiem')}}" class="submit_search" id="search-form">
    <div class="Search">
        <input type="search" class="form-control form-control-dark" name="search_name" value="{{$reQuest ?? null}}" placeholder="Tên khách hàng..." aria-label="Search" />
        <button class="btn btn-primary seach" type="submit"><span data-feather="search"></span></button>
    </div>
    </form>
    <form action="{{route('invoice.tim-kiem-sdt')}}" class="submit_search" id="search-form">
        <div class="Search">
            <input type="number" class="form-control form-control-dark" name="search_sdt" value="{{$reQuestSdt ?? null}}" placeholder="Số điện thoại khách hàng..." aria-label="Search" />
            <button class="btn btn-primary seach" type="submit"><span data-feather="search"></span></button>
        </div>
    </form> -->
    <!-- <form action="{{route('invoice.tim-kiem-date')}}" class="submit_search" id="search-form">
        <div class="Search">
            <input type="date" class="form-control form-control-dark" name="search_date" value="{{ $reQuestDate ?? null }}" aria-label="Search" />

            <button class="btn btn-primary seach" type="submit"><span data-feather="search"></span></button>
        </div>
        </form> -->
    <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('invoice.them-moi') }}" class="btn btn-success"><span data-feather="plus-circle"></span>Thêm mới</a>
        </div>
    </div> -->
</div>  
@if(session('thong_bao'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div> 
              {{session('thong_bao')}}
        </div>
    </div>
@endif
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
{{ $dsinVoice->links('vendor.pagination.default') }}
<script>
function confirmHuyDon(url) {
    if (confirm("Bạn có chắc chắn muốn hủy đơn này?")) {
        window.location.href = url;
    }
}
</script>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function(){

        $('.huy-don-btn').on('click', function(){
        var inVoiceId = $(this).data('id');
        var confirmHuy = false; 

        if (!confirmHuy) {
            var confirmXoa = confirm("Bạn có muốn Xóa hóa đơn này không?");

            if (confirmXoa) {
                window.location.href = "{{ route('invoice.huy-don', '') }}/" + inVoiceId;
            } else {
                window.location.href = "{{ route('invoice.danh-sach') }}";
            }
        }
    
    });
    });
</script>
@endsection