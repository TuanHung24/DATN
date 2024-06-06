@extends('master')

@section('content')

<div class="d-flex justify-connamet-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>THÊM MỚI SẢN PHẨM</h3>
</div>
<form method="POST" action="{{ route('product.hd-add-new') }}" enctype="multipart/form-data">
    @csrf
    <h5 class="offset-md-6">Thông tin sản phẩm:</h5>
    <div class="row">
        <div class="col-md-6">
            <label for="name" class="form-label">Tên sản phẩm:</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
            @error('name')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="chip" class="form-label">Chip:</label>
            <input type="text" id="chip" class="form-control" name="chip" value="{{old('chip')}}">
            @error('chip')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="weight" class="form-label">Trọng lượng(g):</label>
            <input type="number" id="weight" class="form-control" name="weight" step="0.1" value="{{old('weight')}}">
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
                @php
                $selectedValue = old('brand', $Brand->id);
                @endphp
                <option value="{{ $Brand->id }}" {{ $selectedValue ==   $Brand->id ? 'selected' : '' }}>
                    {{ $Brand->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="camera" class="form-label">Camera:</label>
            <input type="text" id="camera" class="form-control" name="camera" value="{{old('camera')}}">
            @error('camera')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="battery" class="form-label">Pin(mAh):</label>
            <input type="number" id="pin" class="form-control" name="battery" value="{{old('battery')}}">
            @error('battery')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea type="text" id="description" class="form-control" name="description">{{old('description')}}</textarea>
            @error('mo_ta')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="size" class="form-label">Kích thước(dài-ngang-dày):</label>
            <textarea type="text" id="size" class="form-control" cols="3" name="size">{{old('size')}}</textarea>
            @error('size')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="screen" class="form-label">Màn hình(inch):</label>
            <input type="number" id="screen" class="form-control" name="screen" step="0.1" value="{{old('screen')}}">
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
            <input type="text" id="os" class="form-control" name="os" value="{{old('os')}}">
            @error('os')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="ram" class="form-label">Ram(GB):</label>
            <input type="number" id="ram" class="form-control" name="ram" value="{{old('ram')}}">
            @error('ram')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 offset-md-6">
                <label for="sims" class="form-label">Sim:</label>
                <input type="text" id="sims" class="form-control" name="sims" value="{{old('sims')}}">
                @error('sims')
                <span class="error-message">{{ $message }}</span>
                @enderror
        </div>
    </div>


    <button type="button" class="btn btn-primary" data-bs-toggle="md" data-bs-target="#newCamera" data-bs-whatever="@mdo">Open md for @mdo</button>

<!-- Modal -->
<div class="md fade" id="newCamera" tabindex="-1" aria-labelledby="newCameraLabel" aria-hidden="true">
    <div class="md-dialog">
        <div class="md-content">
            <div class="md-header">
                <h1 class="md-title fs-5" id="newCameraLabel">New message</h1>
                <button type="button" class="btn-close" data-bs-dismiss="md" aria-label="Close"></button>
            </div>
            <div class="md-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="md-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="md">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
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
            var modal = $(target);
            modal.find('.md-title').text('New message to ' + recipient);
            modal.find('.md-body input').val(recipient);
            modal.addClass('show');
            modal.attr('aria-hidden', 'false');
            modal.css('display', 'block');
        });

        $('.btn-close, .btn-secondary').on('click', function() {
            var modal = $(this).closest('.md');
            modal.removeClass('show');
            modal.attr('aria-hidden', 'true');
            modal.css('display', 'none');
        });
    
    });
  
</script>
@endsection