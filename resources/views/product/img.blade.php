@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT HÌNH ẢNH SẢN PHẨM</h3>
</div>
<x-notification />
@if(isset($listImg) && $listImg->isNotEmpty())
<div class="table-responsive">
    <table class="table table-striped" id="tavle-color-product">
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
                                    <img src="{{ asset($img->img_url) }}" class="img-thumbnail" style="max-width: 100px;">
                                    <div class="overlay position-absolute top-0 start-0 d-none">
                                        <a href="{{ route('product.edit-image', $img->id) }}" class="btn btn-sm btn-warning mt-1">Sửa</a>
                                        @if($index > 0) <!-- Show delete button for images other than the first one -->
                                        <form action="{{ route('product.delete-image', $img->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger mt-1 btn-delete">Xóa</button>
                                        </form>
                                        @endif
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
    <button type="submit" class="btn btn-primary">Cập nhật hình ảnh</button>
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
    });
</script>
@endsection
