@extends('master')


@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH NHẬP KHO</h3>
<button class="btn btn-success" id="showModalButton"><i class="fa-solid fa-file-import"></i> Import Excel</button>

<div class="md fade" id="exampleModal" tabindex="-1" aria-labelledby="examplemdLabel" aria-hidden="true">
    <div class="md-dialog">
        <div class="md-content">
            <div class="md-header">
                <h5 class="md-title" id="examplemdLabel">Import kho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="md" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('warehouse.import') }}" id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="md-body">
                    <input type="file" name="file" id="file" required>
                </div>
                <div class="md-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalButton">Thoát</button>&nbsp;&nbsp;
                    <button  class="btn btn-primary" id="savemdButton">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>



</div>
<div class="custom-search-container">
    <form action="{{ route('warehouse.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />

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
            <td>{{ \Carbon\Carbon::parse($Warehouse->date)->format('d/m/Y H:i') }}</td>
            <td class="chuc-nang">
                <a href="{{ route('warehouse.detail', ['id' => $Warehouse->id]) }}" class="btn btn-outline-info" title="Chi tiết"><i class="fas fa-info-circle"></i></a>
            </td>
        <tr>
            @endforeach
    </table>
    {{ $listWarehouse->links('vendor.pagination.default') }}
</div>
@else
<span class="error">Không có phiếu nhập kho nào!</h6>
    @endif
    @endsection

@section('page-js') 
<script type="text/javascript">
    $(document).ready(function() {
        $('#showModalButton').click(function() {
        $('#exampleModal').addClass('show');
    });
    $('#closeModalButton').click(function() {
        $('#exampleModal').removeClass('show');
    });

    })

    // $('#savemdButton').click(function() {
    //     var formData = new FormData();
    //     formData.append('file', $('#file')[0].files[0]);
    //     formData.append('_token', "{{ csrf_token() }}");

    //     $.ajax({
    //         method: 'POST',
    //         url: "{{ route('warehouse.import') }}",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(response) {
    //             Swal.fire({
    //                 position: 'center',
    //                 icon: 'success',
    //                 title: 'Import thành công!',
    //                 showConfirmButton: true,
    //                 timer: 3000
    //             }).then((result) => {
    //                 if (result.isConfirmed) {
    //                     $('#examplemd').md('hide');
    //                     $("#error-capacity").text("");
    //                     // Nếu muốn chuyển hướng sau khi import thành công
    //                     // window.location.href = "{{ route('capacity.list') }}";
    //                 }
    //             });
    //         },
    //         error: function(xhr, status) {
    //             $("#error-capacity").text(xhr.responseJSON.error);
    //         }
    //     });



    
</script>
@endsection