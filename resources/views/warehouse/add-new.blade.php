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
    <span class="error" id="error-product"></span>
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
    <span class="error" id="error-color"></span>
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
    <input type="number" class="form-control" name="quanlity" id="quanlity" value="1" min="1">
    <span class="error" id="error-quanlity"></span>
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
    <span class="error" id='error-out-price'></span>
  </div>
</div>
<button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
<br>
<br>
<form method="POST" action="{{route('warehouse.hd-add-new')}}">
  @csrf
  <div class="table-responsive">
    <table class="table table-sm" id="tb-ds-product">
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
  <input type="hidden" id="ncc-id" name="provider_id" />
  <!-- <input type="" id="sp-id" name="sp" />
  <input type="" id="mau-id" name="mau" />
  <input type="" id="dl-id" name="dl" /> -->

  <button type="submit" class="btn btn-primary"><span data-feather="save"></span>Lưu</button>

</form>
@endsection

@section('page-js')
<script type="text/javascript">
  $(document).ready(function() {
    var STT = 0;
    var isEditMode = false;
    var editIndex = -1;

    $("#btn-them").click(function() {
      if (!validateInput()) {
        return;
      }

      var stt = $("#tb-ds-product tbody tr").length + 1;
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

      var foundDuplicate = false;

      $("#tb-ds-product tbody tr").each(function() {
        var productId = $(this).find('input[name="idSP[]"]').val();
        var capacityId = $(this).find('input[name="capacity_id[]"]').val();
        var colorId = $(this).find('input[name="color_id[]"]').val();
        var inPrice = $(this).find('input[name="in_price[]"]').val();
        if (idSP == productId && idDL == capacityId && idMS == colorId) {
          var quantityInTable = parseInt($(this).find('td').eq(4).text());
          var newQuantity = quantityInTable + parseInt(soLuong);

          var toTalNew= parseInt(inPrice) * parseInt(newQuantity);

          $(this).find('input[name="quanlity[]"]').val(newQuantity.toString());
          $(this).find('td').eq(4).text(newQuantity.toString());

          $(this).find('input[name="into_money[]"]').val(toTalNew.toString());
          $(this).find('td').eq(7).text(toTalNew.toString());

          foundDuplicate = true;

          if ($(this).find('td').eq(4).find('input[name="quanlity[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            $(this).find('td').eq(4).append(`<input type="hidden" name="quanlity[]" value="${newQuantity}"/>`);
        }
        if ($(this).find('td').eq(7).find('input[name="into_money[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            $(this).find('td').eq(7).append(`<input type="hidden" name="into_money[]" value="${toTalNew}"/>`);
        }
          return false; // Exit the loop since we found a match
        }
      });

      if (!foundDuplicate) {
        var row = `<tr>
      <td>${stt}</td>
      <td>${tenSP}<input type="hidden" name="idSP[]" value="${idSP}"/></td>
      <td>${dungLuong}<input type="hidden" name="capacity_id[]" value="${idDL}"/></td>
      <td>${mauSac}<input type="hidden" name="color_id[]" value="${idMS}"/></td>
      <td>${soLuong}<input type="hidden" name="quanlity[]" value="${soLuong}"/></td>
      <td>${formatNumber(giaNhap)}<input type="hidden" name="in_price[]" value="${giaNhap}"/></td>
      <td>${formatNumber(giaBan)}<input type="hidden" name="out_price[]" value="${giaBan}"/></td>
      <td>${formatNumber(thanhTien)}<input type="hidden" name="into_money[]" value="${thanhTien}"/></td>
      <td>
        <button type="button" class="btn btn-primary btn-sua">Sửa</button>
        <button type="button" class="btn btn-danger btn-xoa">Xóa</button>
      </td>
      </tr>`;

        if (isEditMode) {
          $("#tb-ds-product tbody tr").eq(editIndex).replaceWith(row);
          $('#btn-them').text("Thêm")
          isEditMode = false;
          editIndex = -1;
        } else {
          $('#tb-ds-product').find('tbody').append(row);
          STT++;
          $('#btn-them').text("Thêm")
        }
      }

      clearForm();
      toggleProvider();
    });


    $('#tb-ds-product').on('click', '.btn-xoa', function() {
      $(this).closest('tr').remove();
      STT--;
      toggleProvider();
    });

    $('#tb-ds-product').on('click', '.btn-sua', function() {
      $('#btn-them').text("Sửa")
      var row = $(this).closest('tr');
      var stt = row.index();
      editIndex = stt;
      var tenSP = row.find('td:eq(1)').text();
      var idSP = row.find('input[name="idSP[]"]').val();
      var dungLuong = row.find('td:eq(2)').text();
      var idDL = row.find('input[name="capacity_id[]"]').val();
      var mauSac = row.find('td:eq(3)').text();
      var idMS = row.find('input[name="color_id[]"]').val();
      var soLuong = row.find('td:eq(4)').text();
      var giaNhap = removeCommas(row.find('td:eq(5)').text());
      var giaBan = removeCommas(row.find('td:eq(6)').text());

      $("#product").val(idSP);
      $("#capacity").val(idDL);
      $("#color").val(idMS);
      $("#quanlity").val(soLuong);
      $("#in-price").val(giaNhap);
      $("#out-price").val(giaBan);

      isEditMode = true;
    });

    $("#provider, #product, #color, #capacity, #quanlity, #in-price, #out-price").change(function() {
      $(`#error-${this.id}`).hide();
    });

    $("#provider").click(function() {
      $("#ncc-id").val(this.value);
    });

    // $("#product").click(function() {
    //   $("#sp-id").val(this.value);
    // });

    // $("#color").click(function() {
    //   $("#mau-id").val(this.value);
    // });

    // $("#capacity").click(function() {
    //   $("#dl-id").val(this.value);
    // });

    function validateInput() {
      var isValid = true;

      if ($("#provider").val() === null) {
        $("#error-provider").text("Vui lòng chọn nhà cung cấp!").show();
        isValid = false;
      } else {
        $("#error-provider").text("").hide();
      }

      if ($("#product").val() === null) {
        $("#error-product").text("Vui lòng chọn sản phẩm!").show();
        isValid = false;
      } else {
        $("#error-product").text("").hide();
      }

      if ($("#color").val() === null) {
        $("#error-color").text("Vui lòng chọn màu!").show();
        isValid = false;
      } else {
        $("#error-color").text("").hide();
      }

      if ($("#capacity").val() === null) {
        $("#error-capacity").text("Vui lòng chọn dung lượng!").show();
        isValid = false;
      } else {
        $("#error-capacity").text("").hide();
      }

      var soLuong = parseFloat($("#quanlity").val());

      if (isNaN(soLuong)) {
        $("#error-quanlity").text("Vui lòng nhập số lượng").show();
        isValid = false;
      }
      else if (soLuong <= 0){
        $("#error-quanlity").text("Số lượng không thể là số âm").show();
        isValid = false;
      }
       else {
        $("#error-quanlity").text("").hide();
      }

      var giaNhap = parseFloat($("#in-price").val());
      var giaBan = parseFloat($("#out-price").val());

      if (isNaN(giaNhap)) {
        $("#error-in-price").text("Vui lòng nhập giá nhập!").show();
        isValid = false;
      } else {
        $("#error-in-price").text("").hide();
      }

      if (isNaN(giaBan)) {
        $("#error-out-price").text("Vui lòng nhập giá bán!").show();
        isValid = false;
      } else if (giaBan <= giaNhap) {
        $("#error-out-price").text("Giá bán phải lớn hơn giá nhập!").show();
        isValid = false;
      } else {
        $("#error-out-price").text("").hide();
      }

      return isValid;
    }

    function clearForm() {
      $("#product").val("Chọn sản phẩm");
      $("#color").val("Chọn màu");
      $("#capacity").val("Chọn dung lượng");
      $("#in-price").val("");
      $("#out-price").val("");
      $("#quanlity").val("1");
      $(".error").hide();
    }

    function toggleProvider() {
      if (STT > 0) {
        $('#provider').prop('disabled', true);
      } else {
        $('#provider').prop('disabled', false);
      }
    }



    function formatNumber(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function removeCommas(str) {
      return str.replace(/\./g, '');
    }

    // function checkDuplicateAndAddQuantity() {
    //   var productRows = $("#tb-ds-product tbody tr");

    //   var selectedProductId = $("#product").val();
    //   var selectedCapacityId = $("#capacity").val();
    //   var selectedColorId = $("#color").val();
    //   var quantityToAdd = parseInt($("#quanlity").val());

    //   productRows.each(function() {
    //     var productId = $(this).find('input[name="idSP[]"]').val();
    //     var capacityId = $(this).find('input[name="capacity_id[]"]').val();
    //     var colorId = $(this).find('input[name="color_id[]"]').val();
    //     var quantityInTable = parseInt($(this).find('input[name="quanlity[]"]').val());
    //     console.log()
    //     if (selectedProductId == productId && selectedCapacityId == capacityId && selectedColorId == colorId) {
    //       $(this).find('input[name="quanlity[]"]').val(quantityInTable + quantityToAdd);
    //       clearForm();
    //       return false; // Exit the loop since we found a match
    //     }
    //   });
    // }
  });
</script>
@endsection