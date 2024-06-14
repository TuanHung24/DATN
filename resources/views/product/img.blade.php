@extends('master')

@section('content')

<div class="d-flex justify-connamet-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT HÌNH ẢNH SẢN PHẨM</h3>
</div>

@if(isset($listImg) && $listImg->isNotEmpty())
<div class="table-responsive">
    <table class="table" id="tb-ds-product">
        <thead>
            <tr>

                <th>Màu sắc</th>
                <th>Hình ảnh</th>

            </tr>
        </thead>
        <tbody>
            @foreach($listImg as $Img)
            <tr>
                <td>{{$Img->color->name}}</td>
                <td>{{$Img->capacity->name}}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@else
<span class="error">Không có hình ảnh nào!</span>
@endif
<form method="POST" action="" enctype="multipart/form-data">
    @csrf
    @foreach($listProductDetail as $productDetail)
        
  
   
    <label for="img_{{ $productDetail->id }}" class="custom-file-upload">
        Chọn ảnh cho {{ optional($productDetail->color)->name }}
        <input id="img_{{ $productDetail->id }}" type="file" name="img[]" class="input-file" accept="image/*" multiple>
    </label>
    <br>


    @endforeach
</form>
@endsection