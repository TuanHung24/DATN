@extends('master')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CKEditor Example</title>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h3>THÊM MỚI SLIDE </h3>
            </div>
            <form method="POST" action="{{route('slide-show.hd-add-new')}}" enctype="multipart/form-data">
                @csrf
                     <div class="row">
                    <div class="col-md-4">
                        <label for="product" class="form-label">Sản Phẩm:</label>
                        <select name="product" class="form-select" id="customer" required>
                        <option selected disabled>Chọn sản phẩm</option>
                        @foreach($listProduct as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                        </select>
                        <span class="error" id="error-product"></span>
                    </div>
                    </div>
                    <div class=row>
                    <div class="col-md-6">
                        <label for="img_url" class="form-label">Chọn ảnh: </label>
                        <input type="file" name="img_url" accept="image/*" required /><br />
                    </div>
                    @error('img_url')
                    <span class="error-message"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
@endsection