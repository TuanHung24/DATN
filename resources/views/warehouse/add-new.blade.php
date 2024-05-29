@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3>NHẬP KHO</h3>
</div>
<div class="row">
  <div class="col-md-6"> 
    <label for="provider" class="form-label">Chọn nhà cung cấp:</label>
      <select for="provider" class="form-select" id="provider">
        <option selected disabled>Chọn nhà cung cấp</option>
          @foreach($listProvider as $Provider)
            <option value="{{$Provider->id}}" id="provider">{{$Provider->name}}</option>
          @endforeach
      </select>
    <span class="error" id="error-provider"></span>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="product" class="form-label">Sản phẩm:</label>
      <select name="product" class="form-select" id="product">
        <option selected disabled>Chọn sản phẩm</option>
          @foreach($listProduct as $Product)
            <option value="{{$Product->id}}">{{$Product->name}}</option>
          @endforeach
      </select>
    <span class="error" id = "error-product"></span>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="color" class="form-label">Màu sắc:</label>
    <select name="color" class="form-select" id="color">
      <option selected disabled>Chọn màu</option>
      @foreach($listColor as $Color)
      <option value="{{$Color->id}}">{{$Color->name}}</option>
      @endforeach
    </select>
    <span class="error" id ="error-color"></span>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="capacity" class="form-label">Dung lượng:</label>
    <select name="capacity" class="form-select" id="capacity">
      <option selected disabled>Chọn dung lượng</option>
      @foreach($listCapacity as $Capacity)
      <option value="{{$Capacity->id}}">{{$Capacity->name}}</option>
      @endforeach
    </select>

            <span class="error" id="error-capacity"></span>

  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="quanlity" class="form-label">Số lượng:</label>
    <input type="number" class="form-control" name="quanlity" id="quanlity" value="1">

            <span class="error"></span>

  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="in_price" class="form-label">Giá nhập:</label>
    <input type="number" class="form-control" name="in_price" id="in-price">

            <span class="error" id="error-in-price"></span>

  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="out_price" class="form-label">Giá bán:</label>
    <input type="number" class="form-control" name="out_price" id="out-price">

            <span class="error" id = 'error-out-price'></span>

  </div>
</div>
<button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
<br>
<form method="POST" action="{{route('warehouse.hd-add-new')}}">
  @csrf
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="tb-ds-product">
      <thead>
        <tr>
          <th>STT</th>
          <th>Sản phẩm</th>
          <th>Dung lượng</th>
          <th>Màu sắc</th>
          <th>Số lượng</th>
          <th>Giá nhập</th>
          <th>Giá bán</th>
          <th>Thành tiền</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <input type="" id="ncc-id" name="provider_id" />
  <input type="" id="sp-id" name="sp" />
  <input type="" id="mau-id" name="mau" />
  <input type="" id="dl-id" name="dl" />
  <div class="col-md-2">
    <button type="submit" class="btn btn-primary"><span data-feather="save"></span>Lưu</button>
  </div>
</form> 
@endsection

@section('page-js')
<script type="text/javascript">
  $(document).ready(function() {
    var STT=0 ;var isValid;
    $("#btn-them").click(function() {
      var stt = $("#tb-ds-product tbody tr").length + 1;
      STT=stt;
      var tenSP = $("#product").find(":selected").text();
      var idSP = $("#product").find(":selected").val();
      var dungLuong = $("#capacity").find(":selected").text();
      var idDL = $("#capacity").find(":selected").val();
      var mauSac = $("#color").find(":selected").text();
      var idMS = $("#color").find(":selected").val();
      var soLuong = $("#quanlity").val();
      var giaNhap = $("#in-price").val();
      var giaBan = $("#out-price").val();
      var thanhTien = soLuong * giaNhap;

      if (!validateInput()) {
        return;
       
      }
      
     
      var row = `<tr>
      <td>${stt}</td>
      <td>${tenSP}<input type="hidden" name="idSP[]" value="${idSP}"/></td>
      <td>${dungLuong}<input type="hidden" name="capacity_id[]" value="${idDL}"/></td>
      <td>${mauSac}<input type="hidden" name="color_id[]" value="${idMS}"/></td>
      <td>${soLuong}<input type="hidden" name="quanlity[]" value="${soLuong}"/></td>
      <td>${giaNhap}<input type="hidden" name="in_price[]" value="${giaNhap}"/></td>
      <td>${giaBan}<input type="hidden" name="out_price[]" value="${giaBan}"/></td>
      <td>${thanhTien}<input type="hidden" name="into_money[]" value="${thanhTien}"/></td>
      <td>
        <button type="button" id="btn-xoa" class="btn btn-danger">Xóa</button>
      </td>
      </tr>`;

      $('#tb-ds-product').find('tbody').append(row);
      $("#product").val("Chọn sản phẩm");
      $("#capacity").val("Chọn dung lượng");
      $("#color").val("Chọn màu");
      $("#in-price").val("");
      $("#out-price").val("");
      $("#quanlity").val("1");
      isValid=false;
      
      Test();
      
      
      
    });
    function Test(){
      if(STT>0){
        $('#provider').prop('disabled', true);
      }
      else{
        $('#provider').prop('disabled', false);
      }
    }
    
    $('#tb-ds-product').on('click', '#btn-xoa', function() {
      var tr = $(this).closest('tr');
      tr.remove();
      STT--;
      Test();
    });
    
    $("#provider, #product, #color, #capacity, #quanlity, #in-price, #out-price").change(function() {
      $(`#error-${this.id}`).hide();
    });

    $("#provider").click(function() {
      $("#ncc-id").val(this.value);
    });

    $("#product").click(function() {
      $("#sp-id").val(this.value);
    });

    $("#color").click(function() {
      $("#mau-id").val(this.value);
    });

    $("#capacity").click(function() {
      $("#dl-id").val(this.value);
    });

    function validateInput() {
        isValid =true;
        if ($("#ncc-id").val() === "" || $("#ncc-id").val() === "Chọn nhà cung cấp") {
          $("#error-provider").text("Vui lòng chọn nhà cung cấp!");
          isValid = false;
        } else {
          $("#error-provider").text("");

        }

        if ($("#sp-id").val() === "" || $("#sp-id").val() === "Chọn sản phẩm") {
          $("#error-product").text("Vui lòng chọn sản phẩm!");
          isValid = false;
        } else {
          $("#error-product").text("");

        }

        if ($("#mau-id").val() === "" || $("#mau-id").val() === "Chọn màu") {
          $("#error-color").text("Vui lòng chọn màu!");
          isValid = false;
        } else {
          $("#error-color").text("");

        }

        if ($("#dl-id").val() === "" || $("#dl-id").val() === "Chọn dung lượng") {
          $("#error-capacity").text("Vui lòng chọn dung lượng!");
          isValid = false;

        } else {
          $("#error-capacity").text("");

        }
        var giaNhap = parseFloat($("#in-price").val()); // Xác định giá nhập từ trường nhập liệu
        var giaBan = parseFloat($("#out-price").val()); // Xác định giá bán từ trường nhập liệu
       
        if (isNaN(giaNhap)) {
          $("#error-in-price").text("Vui lòng nhập giá nhập!");
          isValid = false;

        } else {
          $("#error-in-price").text("");

        }
       
       
        if ( isNaN(giaBan)) {
          $("#error-out-price").text("Vui lòng nhập giá bán!");
          isValid = false;
        } else {
            
        if (giaBan <= giaNhap) {
          $("#error-out-price").text("Giá bán phải lớn hơn giá nhập!");
          isValid = false;
        } else {
          $("#error-out-price").text("");
        }
      }
        return isValid;
      }
  });
</script>
@endsection