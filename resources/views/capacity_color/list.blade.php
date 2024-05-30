@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH DUNG LƯỢNG VÀ MÀU</h3>
</div>

<div class="mb-4">
    @if(isset($listCapacity) && $listCapacity->isNotEmpty())
        <div class="table-responsive mb-4">
            <h4 class="mb-3">Danh sách dung lượng</h4>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Mã dung lượng</th>
                        <th scope="col">Tên dung lượng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listCapacity as $capacity)
                    <tr>
                        <td>{{ $capacity->id }}</td>
                        <td>{{ $capacity->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
            Không có dữ liệu dung lượng!
        </div>
    @endif
</div>

<div>
    @if(isset($listColors) && $listColors->isNotEmpty())
        <div class="table-responsive mb-4">
            <h4 class="mb-3">Danh sách màu</h4>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Mã màu</th>
                        <th scope="col">Tên màu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listColors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
            Không có dữ liệu màu!
        </div>
    @endif
</div>
@endsection
