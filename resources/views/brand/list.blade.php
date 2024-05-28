@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 >DANH SÁCH NHÃN HÀNG</h3>
</div>
@if(isset($listBrand) && $listBrand->isNotEmpty($listBrand))
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr> 
                <th>Tên nhãn hàng</td>
            </tr>
        </thead>
        @foreach($listBrand as $Brand)
        <tr>
            <td>{{ $Brand->name }}</td>
            <td>
                <!-- <a href="{{ route('admin.update', ['id' => $Brand->id]) }}">Sửa</a> | <a href="{{ route('admin.delete', ['id' => $Brand->id]) }}">Xóa</a> -->
            </td>
        <tr>
        @endforeach
    </table>
</div>
@else
<h6>Không có nhãn hàng!</h6>
@endif
@endsection