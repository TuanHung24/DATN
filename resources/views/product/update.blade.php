@extends('master')

@section('content')

<div class="d-flex justify-connamet-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT SẢN PHẨM</h3>

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
            <label for="name" class="form-label">Tên sản phẩm:</label>
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
            <select name="brand_id" class="form-select" id="brand" require>
                <option type="text" class="form-control" value="{{ old('brand', $proDuct->brand->id) }}">
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
        <div class="col-md-3">
            <label for="product-series-id" class="form-label">Dòng sản phẩm:</label>
            <select class="form-select" id="product-series-id" name="product_series_id" require>
                <option type="text" class="form-control" value="{{ old('product_series', $proDuct->product_series->id) }}">
                    {{ $proDuct->product_series->name }}
                </option>
                @foreach($listSeries as $ProductSeries)
                @if($ProductSeries->id != $proDuct->product_series->id)
                <option value="{{ $ProductSeries->id }}">
                    {{ $ProductSeries->name }}
                </option>
                @endif
                @endforeach
            </select>
            <span class="error" id="error-product-series-id"></span>
        </div>
        <div class="col-md-3">
            <label for="front-camera" class="form-label">Camera trước:</label>
            <select name="front_camera" class="form-select" id="front-camera" required>
                <option type="text" class="form-control" value="{{old('front_camera',$proDuct->product_description->front_camera->id)}}">
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
                <option type="text" class="form-control" value="{{old('rear_camera',$proDuct->product_description->rear_camera->id)}}">
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
                <option type="text" class="form-control" value="{{old('size_screen',$proDuct->product_description->screen->id)}}">
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
            <input type="number" class="form-control" id="ram" name='ram' value="{{ old('ram', $proDuct->product_description->ram) }}">
            <span class="error" id="error-ram"></span>
            @error('ram')
            <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><span data-feather="save"></span>Lưu</button>
    </div>
</form>
<br />
<div class="row">
    <h5 class="add_color_capacity">Thêm màu sắc, dung lượng cho sản phẩm:</h5>
    <div class="col-md-3 offset-md-3">
        <label for="colors" class="form-label">Chọn màu:</label>
        <select name="colors[]" class="form-select" id="colors">
            @foreach($listColors as $color)
            <option value="{{$color->id}}">{{$color->name}}</option>
            @endforeach
        </select>
        @error('colors')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="capacities" class="form-label">Chọn dung lượng:</label>
        <select name="capacities[]" class="form-select" id="capacities">
            @foreach($listCapacity as $capacity)
            <option value="{{$capacity->id}}">{{$capacity->name}}</option>
            @endforeach
        </select>
        @error('capacities')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="product_plus">
    <button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
</div>

<br>
<div class="row">
    <h5 class="add_color_capacity">Danh sách chi tiết sản phẩm</h5>
</div>
@if(isset($proDuct->product_detail) && $proDuct->product_detail->isNotEmpty())

<div class="table-responsive" id="pr-color-capacity">
    <table class="table" id="tb-ds-product">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Màu sắc</th>
                <th>Dung lượng</th>
                <th>Giá bán</th>
                <th>Số lượng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proDuct->product_detail as $productDetail)
            <tr>
                <td>{{$productDetail->product->name}}</td>
                <td>{{$productDetail->color->name}}</td>
                <td>{{$productDetail->capacity->name}}</td>

                <td>{{empty($productDetail->price) ? 0 : $productDetail->price_formatted}}</td>
                <td>{{empty($productDetail->quantity) ? 0 : $productDetail->quantity}}</td>
                <td><button type="button" class="btn btn-danger btn-xoa" data-id="{{ $productDetail->id }}">Xóa</button></td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-md-9">
        <a href="{{route('product.update-images',['id'=>$proDuct->id])}}" class="btn btn-success">Thêm ảnh</a>
    </div>
</div>
@else
<span class="error">Không có sản phẩm nào!</span>
@endif


@endsection

@section('page-js')
<script type="text/javascript">
    $('#btn-them').click(function() {
        const selectedColors = $('#colors').val();
        const selectedCapacities = $('#capacities').val();

        if (!selectedColors.length || !selectedCapacities.length) {
            alert('Vui lòng chọn màu sắc và dung lượng.');
            return;
        }

        let isExist = false;
        $('#tb-ds-product tbody tr').each(function() {
            const rowColor = $(this).find('td').eq(0).text();
            const rowCapacity = $(this).find('td').eq(1).text();

            if (rowColor === selectedColors && rowCapacity === selectedCapacities) {
                isExist = true;
            }



        });

        if (isExist) {
            alert('Màu sắc và dung lượng này đã tồn tại.');
        } else {
            $.ajax({
                url: '{{ route("product.add-detail", $proDuct->id) }}',
                type: 'POST',
                data: {
                    colors: selectedColors,
                    capacities: selectedCapacities,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.Success) {
                        alert('Thêm màu sắc và dung lượng mới thành công.');
                        location.reload();
                    } else {
                        alert(response.Message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Có lỗi xảy ra khi thêm chi tiết sản phẩm');
                }
            });
        }
    });

    $(document).on('click', '.btn-xoa', function() {
        const productId = $(this).data('id');
        
        const url = '{{ route("product.delete-detail", ":id") }}'.replace(':id', productId);
        if (confirm('Bạn có chắc chắn muốn xóa không?')) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.Success) {
                        $(`tr[data-id='${productId}']`).remove();
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi xóa chi tiết sản phẩm');
                        location.reload();
                    }
                }
            });
        }
    });
</script>
@endsection