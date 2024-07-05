@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH DUNG LƯỢNG</h3>
    <button type="button" class="btn btn-success" id="showModalButton"><i class="fas fa-plus"></i>Thêm mới</button>
</div>
<x-notification />
<div class="md fade" id="exampleModal" tabindex="-1" aria-labelledby="examplemdLabel" aria-hidden="true">
    <div class="md-dialog">
        <div class="md-content">
            <div class="md-header">
                <h1 class="md-title fs-5" id="examplemdLabel">Thêm mới dung lượng</h1>
            </div>
            <div class="md-body">
                <div class="row"> 
                    <div class="col-md-9">
                        <label for="name" class="col-form-label">Tên dung lượng:</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span id="error-capacity" class="error-message"></span>
                    </div>
                    <div class="col-md-2">
                        <label for="unit" class="col-form-label">Đơn vị:</label><br>
                        <select id="capacity-unit" class="form-select">
                            <option selected>GB</option>
                            <option>TB</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="md-footer">
                <button type="button" class="btn btn-secondary" id="closeModalButton">Thoát</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" id="saveModalButton">Lưu</button>
            </div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-6">
        @if($listCapacity->isNotEmpty())
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã dung lượng</th>
                        <th>Tên dung lượng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listCapacity as $capaCity)
                    <tr>
                        <td>{{ $capaCity->id }}</td>
                        <td>{{ $capaCity->name }}</td>
                        <td>
                        <td><a href="{{ route('capacity.delete', ['id' => $capaCity->id]) }}" class="btn btn-outline-danger" title="Xóa"><i class="fas fa-trash"></i></a></td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $listCapacity->links('vendor.pagination.default') }}
        </div>
        @else
        <span class="error">Không có dung lượng!</span>
        @endif
    </div>


</div>
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
       
       
        
        $('#saveModalButton').click(function() {
            var name = $('#name').val();
            var unit =$('#capacity-unit').find(':selected').text();
            
            $.ajax({
                method: 'POST',
                url: "{{route('capacity.hd-add-new')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "name": name,
                    "unit":unit
                },
                success: function(response) {

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: `Thêm dung lượng ${name} thành công!`,
                        showConfirmButton: true,
                        timer: 3000
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#exampleModal').removeClass('show');
                            $("#error-capacity").text("");
                            window.location.href = "{{ route('capacity.list') }}";
                        }
                    });
                },
                error: function(xhr, status) {
                    $("#error-capacity").text(xhr.responseJSON.error);
                }
            });


        });

    });
</script>
@endsection