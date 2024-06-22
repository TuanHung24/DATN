@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT HÌNH ẢNH SẢN PHẨM</h3>
</div>
<x-notification />
@if(isset($listImg) && $listImg->isNotEmpty())
<div class="table-responsive">
    <table class="table table-striped" id="table-color-product">
        <thead>
            <tr>
                <th>Màu sắc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php
                $groupedImages = $listImg->groupBy('color_id');
            @endphp
            @foreach($groupedImages as $colorId => $images)
                <tr>
                    <td>{{ $images->first()->color->name }}</td>
                    <td>
                        <div class="d-flex flex-wrap">
                            @foreach($images as $index => $img)
                                <div class="mr-3 mb-3 position-relative">
                                    <img src="{{ asset($img->img_url) }}" class="img-thumbnail">
                                    <div class="overlay position-absolute top-0 start-0 d-none">
                                        <a href="#" class="btn btn-sm btn-warning mt-1 btn-edit" data-id="{{ $img->id }}">Sửa</a>
                                        @if($index > 0) <!-- Show delete button for images other than the first one -->
                                        <form action="{{ route('product.delete-image', $img->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger mt-1 btn-delete">Xóa</button>
                                        </form>
                                        @endif
                                    </div>
                                    <!-- Hidden form for editing image -->
                                    <div class="edit-form d-none" id="edit-form-{{ $img->id }}">
                                        <form action="{{route('product.update-color', $img->id)}}" method="POST" enctype="multipart/form-data" class="mt-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" name="img" accept="image/*" class="form-control-file mb-2">
                                            <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<span class="error">Không có hình ảnh nào!</span>
@endif

<br>
<br>
<form method="POST" action="{{ route('product.hd-update-images', $id) }}" enctype="multipart/form-data">
    @csrf
    @foreach($uniqueColors as $productDetail)
    <div class="form-group">
        <label for="img_{{ $productDetail->id }}" class="custom-file-upload">
            Màu {{ optional($productDetail->color)->name }}
        </label>
        <input id="img_{{ $productDetail->id }}" title="{{$productDetail->color->name}}" type="file" name="img[{{ $productDetail->color->id }}][]" multiple accept="image/*" class="form-control-file">
    </div>
    @endforeach
    <button type="submit" class="btn btn-success">Thêm hình ảnh</button>
</form>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.img-thumbnail').hover(
            function() {
                $(this).parent().find('.overlay').removeClass('d-none');
            },
            function() {
                $(this).parent().find('.overlay').addClass('d-none');
            }
        );

        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var form = $(this).parent('form');
            var confirmDelete = confirm("Bạn có chắc chắn muốn xóa ảnh này?");
            if (confirmDelete) {
                form.submit();
            }
        });

        $('.btn-edit').click(function(e) {
            e.preventDefault();
            var imgId = $(this).data('id');
            $('#edit-form-' + imgId).toggleClass('d-none');
        });
    });
</script>
@endsection
