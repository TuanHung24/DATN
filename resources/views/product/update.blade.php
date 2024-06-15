@extends('master')

@section('content')

<div class="d-flex justify-connamet-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT SẢN PHẨM</h3>
    <div class="col-md-9">
    <a href="{{route('product.update-images',['id'=>$proDuct->id])}}">Thêm ảnh</a>
    </div>
</div>

@if(session('Error'))
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <div>
        {{session('Error')}}
    </div>
</div>
@endif
<form method="POST" action="{{ route('product.hd-update',['id'=>$proDuct->id]) }}" enctype="multipart/form-data">
    @csrf
    <h5 class="offset-md-6">Thông tin sản phẩm:</h5>
    <div class="row">
        <div class="col-md-4">
            <label for="name" class="form-label">Tên dòng sản phẩm:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $proDuct->name) }}">
            <span class="error" id="error-name"></span>
            @error('name')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
        <div class="col-md-3 offset-md-2">
            <label for="chip" class="form-label">Chip:</label>
            <input type="text" id="chip" class="form-control" name="chip" id="chip" value="{{ old('chip', optional($proDuct->product_description)->chip) }}">
            <span class="error" id="error-chip"></span>
            @error('chip')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="weight" class="form-label">Trọng lượng(g):</label>
            <input type="number" id="weight" class="form-control" name="weight" step="0.1" value="{{ old('weight', optional($proDuct->product_description)->weight) }}">

            <span class="error" id="error-weight"></span>
            @error('weight')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="brand" class="form-label">Hãng sản phẩm:</label>
            <select name="brand" class="form-select" id="brand" require>
                <option type="text" class="form-control" name="brand" value="{{ old('brand', $proDuct->brand->id) }}">
                    {{ $proDuct->brand->name }}
                </option>
                @foreach($listBrand as $Brand)
                @if($Brand->id != $proDuct->brand->id)
                <option value="{{ $Brand->id }}">
                    {{ $Brand->name }}
                </option>
                @endif
                @endforeach

            </select>

            <span class="error" id="error-brand"></span>
        </div>
        <div class="col-md-3 offset-md-3">
            <label for="front-camera" class="form-label">Camera trước:</label>
            <select name="front_camera" class="form-select" id="front-camera" required>
                <option type="text" class="form-control" name="front_camera" value="{{old('front_camera',$proDuct->product_description->front_camera->id)}}">
                    {{$proDuct->product_description->front_camera->resolution . ' ' . $proDuct->product_description->front_camera->record}}
                </option>
                @foreach($listFrontCamera as $frontCamera)
                @if($frontCamera->id != $proDuct->product_description->front_camera->id)
                <option value="{{$frontCamera->id}}">{{$frontCamera->resolution . ' ' . $frontCamera->record}}</option>
                @endif
                @endforeach
            </select>
            <span class="error" id="error-front-camera"></span>
        </div>

        <div class="col-md-3">
            <label for="rear-camera" class="form-label">Camera sau:</label>
            <select name="rear_camera" class="form-select" id="rear-camera" required>
                <option type="text" class="form-control" name="rear_camera" value="{{old('rear_camera',$proDuct->product_description->rear_camera->id)}}">
                    {{$proDuct->product_description->rear_camera->resolution . ' ' . $proDuct->product_description->rear_camera->record}}
                </option>
                @foreach($listRearCamera as $rearCamera)
                @if($rearCamera->id != $proDuct->product_description->rear_camera->id)
                <option value="{{$rearCamera->id}}">{{$rearCamera->resolution . ' ' . $rearCamera->record}}</option>
                @endif
                @endforeach
            </select>
            <span class="error" id="error-rear-camera"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea type="text" id="description" class="form-control" id="description" name="description">{{ old('description',$proDuct->description) }}</textarea>

        </div>
        <div class="col-md-3">
            <label for="size-screen" class="form-label">Độ phân giải - Màn hình:</label>
            <select name="size_screen" class="form-select" id="size-screen" required>
                <option type="text" class="form-control" name="size_screen" value="{{old('size_screen',$proDuct->product_description->screen->id)}}">
                    {{$proDuct->product_description->screen->resolution . ' - ' . $proDuct->product_description->screen->size}}
                </option>
                @foreach($listScreen as $Screen)
                @if($Screen->id != $proDuct->product_description->screen->id)
                <option value="{{$Screen->id}}">{{$Screen->resolution . ' - ' . $Screen->size}}</option>
                @endif
                @endforeach
            </select>
            <span class="error" id="error-size-screen"></span>
        </div>
        <div class="col-md-3">
            <label for="os" class="form-label">Hệ điều hành:</label>
            <input type="text" class="form-control" name="os" id="os" value="{{ old('os', $proDuct->product_description->os) }}">
            <span class="error" id="error-os"></span>
            @error('os')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 offset-md-6">
            <label for="sims" class="form-label">Sim:</label>
            <input type="text" id="sims" class="form-control" name="sims" id="sims" value="{{ old('sims', $proDuct->product_description->sims) }}">
            <span class="error" id="error-sims"></span>
            @error('sims')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="battery" class="form-label">Pin(mAh):</label>
            <input type="number" class="form-control" name="battery" id="battery" value="{{ old('battery', $proDuct->product_description->battery) }}">
            <span class="error" id="error-battery"></span>
            @error('battery')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
        <div class="col-md-3 offset-md-6">
            <label for="ram" class="form-label">Ram(GB):</label>
            <input type="number" class="form-control" id="ram" value="{{ old('ram', $proDuct->product_description->ram) }}">
            <span class="error" id="error-ram"></span>
            @error('ram')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
    </div>
    <label>Chi tiết dòng sản phẩm:</label>
    @if(isset($proDuct->product_detail) && $proDuct->product_detail->isNotEmpty())
    <div class="table-responsive">
        <table class="table" id="tb-ds-product">
            <thead>
                <tr>
                    
                    <th>Màu sắc</th>
                    <th>Dung lượng</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
            @foreach($proDuct->product_detail as $productDetail)
                <tr>
                    
                    
                    <td>{{$productDetail->color->name}}</td>
                    <td>{{$productDetail->capacity->name}}</td>
                    
                    <td>{{empty($productDetail->price) ? 0 : $productDetail->price_formatted}}</td>
                    <td>{{empty($productDetail->quantity) ? 0 : $productDetail->quantity}}</td>
                    <td></td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <span class="error">Không có sản phẩm nào!</span>
    @endif
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><span data-feather="save"></span>Lưu</button>
    </div>
</form>
@endsection