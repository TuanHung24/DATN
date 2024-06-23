@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>THÊM MỚI SẢN PHẨM</h3>
</div>
@if(session('Error'))
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <div>
        {{session('Error')}}
    </div>
</div>
@endif

<h5 class="offset-md-6">Thông tin sản phẩm:</h5>
<div class="row">
    <div class="col-md-3">
        <label for="brand" class="form-label">Hãng sản phẩm:</label>
        <select name="brand" class="form-select" id="brand" require>
            <option selected disabled>Chọn hãng sản phẩm</option>
            @foreach($listBrand as $Brand)
            <option value="{{ $Brand->id }}">
                {{ $Brand->name }}
            </option>
            @endforeach
        </select>
        <span class="error" id="error-brand"></span>
    </div>
    <div class="col-md-3">
        <label for="product-series-id" class="form-label">Dòng sản phẩm:</label>
        <select class="form-select" id="product-series-id" require>
            <option selected disabled>Chọn dòng sản phẩm</option>
            @foreach($listSeries as $ProductSeries)
            <option value="{{ $ProductSeries->id }}">
                {{ $ProductSeries->name }}
            </option>
            @endforeach
        </select>
        <span class="error" id="error-product-series-id"></span>
    </div>
    <div class="col-md-3">
        <label for="chip" class="form-label">Chip:</label>
        <input type="text" id="chip" class="form-control" name="chip" id="chip" value="{{ old('chip') }}">
        <span class="error" id="error-chip"></span>
        @error('chip')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="weight" class="form-label">Trọng lượng(g):</label>
        <input type="number" id="weight" class="form-control" id="weight" name="weight" step="0.1" value="{{ old('weight') }}">
        <span class="error" id="error-weight"></span>
        @error('weight')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label for="name" class="form-label">Tên sản phẩm:</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
        <span class="error" id="error-name"></span>
        @error('name')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>

    <div class="col-md-3 offset-md-2">
        <label for="front-camera" class="form-label">Camera trước:</label>
        <select name="front_camera" class="form-select" id="front-camera" required>
            <option selected disabled>Chọn camera trước</option>
            @foreach($listFrontCamera as $frontCamera)
            <option value="{{$frontCamera->id}}">{{$frontCamera->resolution . ' ' . $frontCamera->record}}</option>
            @endforeach
        </select>
        <span class="error" id="error-front-camera"></span>
    </div>

    <div class="col-md-3">
        <label for="rear-camera" class="form-label">Camera sau:</label>
        <select name="rear_camera" class="form-select" id="rear-camera" required>
            <option selected disabled>Chọn camera sau</option>
            @foreach($listRearCamera as $rearCamera)
            <option value="{{$rearCamera->id}}">{{$rearCamera->resolution . ' ' . $rearCamera->record}}</option>
            @endforeach
        </select>
        <span class="error" id="error-rear-camera"></span>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="description" class="form-label">Mô tả:</label>
        <textarea type="text" id="description" class="form-control" id="description" name="description">{{ old('description') }}</textarea>
    </div>
    <div class="col-md-3 ">
        <label for="size-screen" class="form-label">Độ phân giải - Màn hình:</label>
        <select name="size_screen" class="form-select" id="size-screen" required>
            <option selected disabled>Chọn độ phân giải - màn hình</option>
            @foreach($listScreen as $Screen)
            <option value="{{$Screen->id}}">{{$Screen->resolution . ' - ' . $Screen->size}}</option>
            @endforeach
        </select>
        <span class="error" id="error-size-screen"></span>
    </div>
    <div class="col-md-3">
        <label for="os" class="form-label">Hệ điều hành:</label>
        <input type="text" class="form-control" name="os" id="os" value="{{ old('os') }}">
        <span class="error" id="error-os"></span>
        @error('os')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-3 offset-md-6">
        <label for="sims" class="form-label">Sim:</label>
        <input type="text" id="sims" class="form-control" name="sims" id="sims" value="{{ old('sims') }}">
        <span class="error" id="error-sims"></span>
        @error('sims')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="battery" class="form-label">Pin(mAh):</label>
        <input type="number" class="form-control" name="battery" id="battery" value="{{ old('battery') }}">
        <span class="error" id="error-battery"></span>
        @error('battery')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="col-md-3 offset-md-6">
        <label for="ram" class="form-label">Ram(GB):</label>
        <input type="number" class="form-control" id="ram" value="{{ old('ram') }}">
        <span class="error" id="error-ram"></span>
        @error('ram')
        <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
</div>

<div class="row">
    <h5 class="add_color_capacity">Thêm màu sắc, dung lượng cho sản phẩm:</h5>
    <div class="col-md-3 offset-md-3">
        <label for="colors" class="form-label">Chọn màu:</label>
        <select name="colors[]" class="form-select" id="colors" multiple>
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
        <select name="capacities[]" class="form-select" id="capacities" multiple>
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

<br />

<form method="POST" action="{{ route('product.hd-add-new') }}" enctype="multipart/form-data">
    @csrf
    <h5>Bảng màu sắc, dung lượng sản phẩm:</h5>
    <div class="table-responsive" id="pr-color-capacity">
        <table class="table" id="tb-ds-product">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Màu sắc</th>
                    <th>Dung lượng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <br />
    <input type="hidden" id="brand-id" name="brand_id" />
    <input type="hidden" id="product-name" name="product_name" />
    <input type="hidden" id="hd-product-series-id" name="product_series_id" />
    <input type="hidden" id="hd-description" name="hd_description" />
    <input type="hidden" id="hd-chip" name="hd_chip" />
    <input type="hidden" id="hd-front-camera" name="hd_front_camera" />
    <input type="hidden" id="hd-rear-camera" name="hd_rear_camera" />
    <input type="hidden" id="hd-screen" name="hd_screen" />
    <input type="hidden" id="hd-sims" name="hd_sims" />
    <input type="hidden" id="hd-weight" name="hd_weight" />
    <input type="hidden" id="hd-battery" name="hd_battery" />
    <input type="hidden" id="hd-os" name="hd_os" />
    <input type="hidden" id="hd-ram" name="hd_ram" />

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><span data-feather="save"></span>Lưu</button>
    </div>
</form>

@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        var count = 0;

        $('#btn-them').on('click', function() {

            if (!validateInput()) {
                return;
            }
            var colors = $('#colors').val();
            var capacities = $('#capacities').val();
            var nameproduct = $('#name').val();
            var series = $('#product-series-id option:selected').text(); // Get the selected series name
            var productName = series + ' ' + nameproduct; // Combine series and input name
            var tbody = $('#tb-ds-product tbody');

            if (colors.length === 0 || capacities.length === 0) {
                alert('Vui lòng chọn màu sắc và dung lượng.');
                return;
            }

            var existingEntries = [];
            var addedEntries = false;

            // Check each selected color and capacity combination
            colors.forEach(function(color) {
                capacities.forEach(function(capacity) {
                    // Check if the combination already exists in the table
                    var exists = false;
                    $('#tb-ds-product tbody tr').each(function() {
                        var existingColor = $(this).find('td:nth-child(2)').data('id');
                        var existingCapacity = $(this).find('td:nth-child(3)').data('id');
                        if (existingColor == color && existingCapacity == capacity) {
                            exists = true;
                            return false; // Exit the loop early if found
                        }
                    });

                    if (!exists) {
                        count++;
                        var row = '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td data-id="' + color + '">' + $('#colors option[value="' + color + '"]').text() + '<input type="hidden" id="colorInput" value="' + color + '" name="color_id[]"></td>' +
                            '<td data-id="' + capacity + '">' + $('#capacities option[value="' + capacity + '"]').text() + '<input type="hidden" id="capacityInput" value="' + capacity + '" name="capacity_id[]"></td>' +
                            '<td><button type="button" class="btn btn-danger btn-xoa">Xóa</button></td>' +
                            '</tr>';
                        tbody.append(row);
                        addedEntries = true;
                    } else {
                        // Display an alert if the combination already exists
                        alert('Màu sắc và dung lượng đã tồn tại trong bảng.');
                    }
                });
            });

            if (addedEntries) {
                updateHiddenFields();
            }
        });

        $('#tb-ds-product').on('click', '.btn-xoa', function() {
            $(this).closest('tr').remove();
            updateTableIndexes();
            updateHiddenFields();
        });

        // Function to update table row indexes
        function updateTableIndexes() {
            $('#tb-ds-product tbody tr').each(function(index, row) {
                $(row).find('td:first').text(index + 1);
            });
        }

        function validateInput() {
            var isValid = true;

            // Validate product name
            var productName = $('#name').val();
            if (!productName.trim()) {
                $('#error-name').text('Vui lòng nhập tên dòng sản phẩm!').show();
                isValid = false;
            } else {
                $('#error-name').text('').hide();
            }

            // Validate brand
            var brandId = $('#brand').val();
            if (!brandId) {
                $('#error-brand').text('Vui lòng chọn hãng sản phẩm!').show();
                isValid = false;
            } else {
                $('#error-brand').text('').hide();
            }

            var series = $('#product-series-id').val();
            if (!series) {
                $('#error-product-series-id').text('Vui lòng chọn series sản phẩm!').show();
                isValid = false;
            } else {
                $('#error-brand').text('').hide();
            }

            var oS = $('#os').val();
            if (!oS) {
                $('#error-os').text('Vui lòng nhập hệ điều hành!').show();
                isValid = false;
            } else {
                $('#error-os').text('').hide();
            }

            // Validate chip
            var chip = $('#chip').val();
            if (!chip.trim()) {
                $('#error-chip').text('Vui lòng nhập thông tin Chip!').show();
                isValid = false;
            } else {
                $('#error-chip').text('').hide();
            }

            var ram = $('#ram').val();
            if (!ram.trim()) {
                $('#error-ram').text('Vui lòng nhập thông tin Ram!').show();
                isValid = false;
            } else {
                $('#error-ram').text('').hide();
            }

            // Validate front camera
            var frontCamera = $('#front-camera').val();
            if (!frontCamera) {
                $('#error-front-camera').text('Vui lòng chọn camera trước!').show();
                isValid = false;
            } else {
                $('#error-front-camera').text('').hide();
            }

            // Validate rear camera
            var rearCamera = $('#rear-camera').val();
            if (!rearCamera) {
                $('#error-rear-camera').text('Vui lòng chọn camera sau!').show();
                isValid = false;
            } else {
                $('#error-rear-camera').text('').hide();
            }

            // Validate screen size
            var screenSize = $('#size-screen').val();
            if (!screenSize) {
                $('#error-size-screen').text('Vui lòng chọn độ phân giải - màn hình!').show();
                isValid = false;
            } else {
                $('#error-size-screen').text('').hide();
            }

            // Validate sims
            var sims = $('#sims').val();
            if (!sims.trim()) {
                $('#error-sims').text('Vui lòng nhập thông tin SIM!').show();
                isValid = false;
            } else {
                $('#error-sims').text('').hide();
            }

            // Validate battery
            var battery = $('#battery').val();
            if (!battery) {
                $('#error-battery').text('Vui lòng nhập dung lượng pin!').show();
                isValid = false;
            } else {
                $('#error-battery').text('').hide();
            }

            // Validate weight
            var weight = $('#weight').val();
            if (!weight) {
                $('#error-weight').text('Vui lòng nhập trọng lượng!').show();
                isValid = false;
            } else {
                $('#error-weight').text('').hide();
            }

            return isValid;
        }

        // Function to update hidden fields storing selected colors and capacities
        function updateHiddenFields() {
            var selectedColors = [];
            var selectedCapacities = [];
            $('#tb-ds-product tbody tr').each(function() {
                selectedColors.push($(this).find('td:nth-child(2)').data('id'));
                selectedCapacities.push($(this).find('td:nth-child(3)').data('id'));
            });
            $('#selectedColors').val(JSON.stringify(selectedColors));
            $('#selectedCapacities').val(JSON.stringify(selectedCapacities));
        }

        // Event handlers for other fields (name, chip, weight, description, sims, battery, brand, size-screen, front-camera, rear-camera)
        $('#name, #chip, #weight, #description, #sims, #battery, #ram, #os').on('input', function() {
            $('#product-name').val($('#name').val());
            $('#hd-chip').val($('#chip').val());
            $('#hd-weight').val($('#weight').val());
            $('#hd-description').val($('#description').val());
            $('#hd-sims').val($('#sims').val());
            $('#hd-battery').val($('#battery').val());
            $('#hd-ram').val($('#ram').val());
            $('#hd-os').val($('#os').val());
        });

        $('#brand,#product-series-id, #size-screen, #front-camera, #rear-camera').on('change', function() {
            $('#brand-id').val($('#brand').val());
            $('#hd-product-series-id').val($('#product-series-id').val());
            $('#hd-screen').val($('#size-screen').val());
            $('#hd-front-camera').val($('#front-camera').val());
            $('#hd-rear-camera').val($('#rear-camera').val());
        });

        $('#product-series-id').on('change', function() {
            var selectedSeries = $(this).find(':selected').text().trim();
            $('#name').val(selectedSeries);
        });
    });
</script>


@endsection