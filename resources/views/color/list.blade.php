@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH MÀU SẮC</h3>
    <button type="button" class="btn btn-success" id="showModalButton"><i class="fas fa-plus"></i>Thêm mới</button>

</div>

<x-notification />

<div class="md fade" id="exampleModal" tabindex="-1" aria-labelledby="examplemdLabel" aria-hidden="true">
    <div class="md-dialog">
        <div class="md-content">
            <div class="md-header">
                <h1 class="md-title fs-5" id="examplemdLabel">Thêm mới màu sắc</h1>
            </div>
            <div class="md-body">

                <div class="mb-3">
                    <label for="name" class="col-form-label">Tên màu:</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <span id="error-color" class="error-message"></span>
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
        @if($listColors->isNotEmpty())
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã màu</th>
                        <th>Tên màu</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listColors as $coLor)
                    <tr>
                        <td>{{ $coLor->id }}</td>
                        <td>{{ $coLor->name }}</td>
                        <td><a href="{{ route('color.delete', ['id' => $coLor->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $listColors->links('vendor.pagination.default') }}
        </div>
        @else
        <span class="error">Không có màu!</span>
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
            console.log(name)
            $.ajax({
                method: 'POST',
                url: "{{route('color.hd-add-new')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "name": name
                },
                success: function(response) {

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: `Thêm màu sắc ${name} thành công!`,
                        showConfirmButton: true,
                        timer: 3000
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#exampleModal').removeClass('show');
                            $("#error-color").text("");
                            window.location.href = "{{ route('color.list') }}";
                        }
                    });
                },
                error: function(xhr, status) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Lấy thông báo lỗi từ phản hồi JSON
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = errors.name ? errors.name[0] : 'Có lỗi xảy ra, vui lòng thử lại.';
                        $("#error-color").text(errorMessage);
                    } else {
                        // Trường hợp lỗi không phải JSON hoặc không có thông báo lỗi cụ thể
                        $("#error-color").text(xhr.responseJSON.error);
                    }
                }
            });


        });

    });
</script>
@endsection