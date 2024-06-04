@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>THÊM MỚI KHUYẾN MÃI</h3>
</div>
<form method="POST" action="{{ route('customer.hd-add-new') }}">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <label for="name" class="form-label">Tên khuyến mãi</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
        </div>
        @error('name')
            <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="date-start" class="form-label">Ngày bắt đầu</label>
            <input type="datetime-local" class="form-control" name="date_start" id="date-start" value="{{old('date_start')}}">
            @error('date_start')
                <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label for="date-end" class="form-label">Ngày kết thúc</label>
            <input type="datetime-local" class="form-control" name="date_end" id="date-end" value="{{old('date_end')}}">
            @error('date_end')
                <span class="error-message"> {{ $message }} </span>
            @enderror
        </div>
       
    </div>
    <div class="row">
        <div class="col-md-2">
            <label for="percent" class="form-label">Phần trăm khuyễn mãi</label>
            <input type="number" class="form-control" name="percent" value="{{old('percent')}}">
        </div>
        @error('percent')
            <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <label for="percent" class="form-label">Phần trăm khuyễn mãi</label>
            <input type="number" class="form-control" name="percent" value="{{old('percent')}}">
        </div>
        @error('percent')
            <span class="error-message"> {{ $message }} </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>Tìm kiếm</label>
            <select name="product" class="form-select" id="product">
                <option selected disabled>Chọn sản phẩm</option>
                @foreach($listProduct as $proDuct)
                <option value="{{$proDuct->id}}">{{$proDuct->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
</form>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#date-start').click({
      format: 'yyyy-mm-dd', // Set date format
      autoclose: true // Close picker on date selection
    });

    // Initialize timepickers
    $('#date-end').timepicker({
      showSeconds: true, // Display seconds option
      timeFormat: 'hh:mm:ss' // Set time format
    });
    
  });
</script>
@endsection
