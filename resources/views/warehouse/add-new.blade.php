@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3>NHẬP KHO</h3>
</div>
<div class="row">
  <div class="col-md-3">
    <label for="provider" class="form-label">Nhà cung cấp:</label>
    <select for="provider" class="form-select" id="provider">
      <option selected disabled>Chọn nhà cung cấp</option>
      @foreach($listProvider as $Provider)
      <option value="{{$Provider->id}}" id="provider">{{$Provider->name}}</option>
      @endforeach
    </select>
    <span class="error" id="error-provider"></span>
  </div>

  <div class="col-md-2">
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
  <div class="col-md-2">
    <label for="color" class="form-label">Màu sắc:</label>
    <select name="color" class="form-select" id="color">
      <option selected disabled>Chọn màu</option>
      @foreach($listColor as $Color)
      <option value="{{$Color->id}}">{{$Color->name}}</option>
      @endforeach
    </select>
    <span class="error" id="error-color"></span>
  </div>
  <div class="offset-md-1 col-md-2">
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
  
</div>
<div class="row">
  <div class="col-md-1">
    <label for="quanlity" class="form-label">Số lượng:</label>
    <input type="number" class="form-control" name="quanlity" id="quanlity" value="1" min="1">
    <span class="error" id="error-quanlity"></span>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <label for="in_price" class="form-label">Giá nhập:</label>
    <input type="number" class="form-control" name="in_price" id="in-price">
    <span class="error" id="error-in-price"></span>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
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
    <table class="table" id="tb-ds-product">
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

      if (isEditMode) {
        // Sửa thông tin sản phẩm
        var row = $("#tb-ds-product tbody tr").eq(editIndex);
        row.find('td:eq(1)').text(tenSP).append(`<input type="hidden" name="idSP[]" value="${idSP}"/>`);
        row.find('td:eq(2)').text(dungLuong).append(`<input type="hidden" name="capacity_id[]" value="${idDL}"/>`);
        row.find('td:eq(3)').text(mauSac).append(`<input type="hidden" name="color_id[]" value="${idMS}"/>`);
        row.find('td:eq(4)').text(soLuong).append(`<input type="hidden" name="quanlity[]" value="${soLuong}"/>`);
        row.find('td:eq(5)').text(formatNumber(giaNhap)).append(`<input type="hidden" name="in_price[]" value="${giaNhap}"/>`);
        row.find('td:eq(6)').text(formatNumber(giaBan)).append(`<input type="hidden" name="out_price[]" value="${giaBan}"/>`);
        row.find('td:eq(7)').text(formatNumber(thanhTien)).append(`<input type="hidden" name="into_money[]" value="${thanhTien}"/>`);
        
        isEditMode = false;
        editIndex = -1;
        $('#btn-them').text("Thêm");
      } else {
        // Thêm sản phẩm mới
        $("#tb-ds-product tbody tr").each(function() {
          var productId = $(this).find('input[name="idSP[]"]').val();
          var capacityId = $(this).find('input[name="capacity_id[]"]').val();
          var colorId = $(this).find('input[name="color_id[]"]').val();
          if (idSP == productId && idDL == capacityId && idMS == colorId) {
            foundDuplicate = true;

            if (confirm('Sản phẩm đã tồn tại, bạn có muốn cập nhật số lượng và giá mới không?')) {
              var newQuantity = parseInt($(this).find('input[name="quanlity[]"]').val()) + parseInt(soLuong);
              var newTotal = parseInt(giaNhap) * newQuantity;

              $(this).find('input[name="quanlity[]"]').val(newQuantity.toString());
              $(this).find('td').eq(4).text(newQuantity.toString());

              $(this).find('input[name="in_price[]"]').val(giaNhap.toString());
              $(this).find('td').eq(5).text(formatNumber(giaNhap.toString()));

              $(this).find('input[name="out_price[]"]').val(giaBan.toString());
              $(this).find('td').eq(6).text(formatNumber(giaBan.toString()));

              $(this).find('input[name="into_money[]"]').val(newTotal.toString());
              $(this).find('td').eq(7).text(formatNumber(newTotal));

              return false; // Thoát khỏi vòng lặp nếu tìm thấy bản sao
            }
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

          $('#tb-ds-product').find('tbody').append(row);
          STT++;
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
      $('#btn-them').text("Sửa");
      var row = $(this).closest('tr');
      editIndex = row.index();
      var idSP = row.find('input[name="idSP[]"]').val();
      var idDL = row.find('input[name="capacity_id[]"]').val();
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
      } else if (soLuong <= 0) {
        $("#error-quanlity").text("Số lượng không thể là số âm").show();
        isValid = false;
      } else {
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

    function removeCommas(x) {
      return x.replace(/\./g, "");
    }
  });
</script>

@endsection
