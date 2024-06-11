@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH DUNG LƯỢNG VÀ MÀU</h3>
</div>
<div class="row">
    <div class="col-md-6">
        @if(isset($listCapacity) && $listCapacity->isNotEmpty())
        <h4 class="mb-3">Danh sách dung lượng</h4>
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
                    @foreach($listCapacity as $capacity)
                    <tr>
                        <td>{{ $capacity->id }}</td>
                        <td>{{ $capacity->name }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <span class="error">Không có dung lượng!</span>
        @endif
    </div>

    <div class="col-md-6">
        @if(isset($listColors) && $listColors->isNotEmpty())
        <h4 class="mb-3">Danh sách màu</h4>
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
                    @foreach($listColors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <span class="error">Không có màu!</span> 
        @endif
    </div>
</div>
@endsection
