@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>THÊM MỚI SẢN PHẨM</h3>
</div>
<form method="POST" action="{{ route('product.hd-add-new') }}" enctype="multipart/form-data">
    @csrf
    <h5 class="offset-md-6">Thông tin sản phẩm:</h5>
    <div class="row">
        <div class="col-md-6">
            <label for="name" class="form-label">Tên sản phẩm:</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            @error('name')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="chip" class="form-label">Chip:</label>
            <input type="text" id="chip" class="form-control" name="chip" value="{{ old('chip') }}">
            @error('chip')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="weight" class="form-label">Trọng lượng(g):</label>
            <input type="number" id="weight" class="form-control" name="weight" step="0.1" value="{{ old('weight') }}">
            @error('weight')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="brand" class="form-label">Hãng sản phẩm:</label>
            <select name="brand" class="form-select">
                @foreach($listBrand as $Brand)
                <option value="{{ $Brand->id }}" {{ old('brand') == $Brand->id ? 'selected' : '' }}>
                    {{ $Brand->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="camera" class="form-label">Camera:</label>
            <input type="text" id="camera" class="form-control" name="camera" value="{{ old('camera') }}">
            @error('camera')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="battery" class="form-label">Pin(mAh):</label>
            <input type="number" id="battery" class="form-control" name="battery" value="{{ old('battery') }}">
            @error('battery')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea type="text" id="description" class="form-control" name="description">{{ old('description') }}</textarea>
            @error('description')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="size" class="form-label">Kích thước(dài-ngang-dày):</label>
            <textarea type="text" id="size" class="form-control" name="size">{{ old('size') }}</textarea>
            @error('size')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="screen" class="form-label">Màn hình(inch):</label>
            <input type="number" id="screen" class="form-control" name="screen" step="0.1" value="{{ old('screen') }}">
            @error('screen')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="img[]" class="form-label">Chọn ảnh: </label>
            <input type="file" name="img[]" multiple required /><br />
            @error('img')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 offset-md-3">
            <label for="os" class="form-label">Hệ điều hành:</label>
            <input type="text" id="os" class="form-control" name="os" value="{{ old('os') }}">
            @error('os')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="ram" class="form-label">Ram(GB):</label>
            <input type="number" id="ram" class="form-control" name="ram" value="{{ old('ram') }}">
            @error('ram')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 offset-md-6">
            <label for="sims" class="form-label">Sim:</label>
            <input type="text" id="sims" class="form-control" name="sims" value="{{ old('sims') }}">
            @error('sims')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><span data-feather="save"></span>Lưu</button>
    </div>
</form>

@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-bs-toggle="md"]').on('click', function(event) {
            var target = $(this).data('bs-target');
            var recipient = $(this).data('bs-whatever');
            var md = $(target);
            md.find('.md-title').text('New message to ' + recipient);
            md.find('.md-body input').val(recipient);
            md.addClass('show');
            md.attr('aria-hidden', 'false');
            md.css('display', 'block');
        });

        $('.btn-close, .btn-secondary').on('click', function() {
            var md = $(this).closest('.md');
            md.removeClass('show');
            md.attr('aria-hidden', 'true');
            md.css('display', 'none');
        });
    });
</script>
@endsection