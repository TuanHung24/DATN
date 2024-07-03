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
  <div class="col-md-3">
    <label for="series" class="form-label">Dòng sản phẩm:</label>
    <select name="series" class="form-select" id="series">
      <option selected disabled>Chọn dòng sản phẩm</option>
      @foreach($listSeries as $series)
      <option value="{{$series->id}}">{{$series->name}}</option>
      @endforeach
    </select>
    <span class="error" id="error-series"></span>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <label for="productDetails" class="form-label">Chọn sản phẩm:</label>
    <select name="productDetails" class="form-select" id="productDetails">
      <option selected disabled>Chọn sản phẩm</option>
    </select>
    <span class="error" id="error-product"></span>
  </div>

</div>
<div class="row">
  <div class="col-md-2">
    <label for="quantity" class="form-label">Số lượng:</label>
    <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1">
    <span class="error" id="error-quantity"></span>
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
<div>
  <button type="button" id="btn-them" class="btn btn-success">Thêm</button>
</div>

<br>
<form method="POST" action="{{route('warehouse.hd-add-new')}}">
  @csrf
  <div class="table-responsive">
    <table class="table" id="tb-ds-product">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên dòng sản phẩm</th>
          <th>Sản phẩm</th>
          <th>Số lượng</th>
          <th>Giá nhập</th>
          <th>Giá bán</th>
          <th>Thành tiền</th>
          <th>Chức năng</th>
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

      var stt = isEditMode ? editIndex + 1 : $("#tb-ds-product tbody tr").length + 1;

      var nameSeries = $("#series option:selected").text();
      var idSeries = $("#series").val();
      var nameDetail = $("#productDetails option:selected").text();
      var idDetail = $("#productDetails").val();
      var soLuong = parseInt($("#quantity").val());
      var giaNhap = parseFloat($("#in-price").val());
      var giaBan = parseFloat($("#out-price").val());
      var thanhTien = soLuong * giaNhap;

      var foundDuplicate = false;

      // Loop through existing rows to check for duplicates
      $("#tb-ds-product tbody tr").each(function(index) {
        var seriesId = $(this).find('input[name="id_series[]"]').val();
        var detailId = $(this).find('input[name="id_detail[]"]').val();

        if (idSeries == seriesId && idDetail == detailId && index !== editIndex) {
          foundDuplicate = true;
          if (confirm('Sản phẩm đã tồn tại, bạn có muốn cập nhật số lượng và giá mới không?')) {
            var existingQuantity = parseInt($(this).find('input[name="quantity[]"]').val());
            var newQuantity = existingQuantity + parseInt(soLuong);
            var newTotal = parseFloat(giaNhap) * newQuantity;

            // Update the existing row with new values
            $(this).find('td').eq(3).text(newQuantity);
            $(this).find('td').eq(4).text(formatNumber(giaNhap));
            $(this).find('td').eq(5).text(formatNumber(giaBan));
            $(this).find('td').eq(6).text(formatNumber(newTotal));

            $(this).find('input[name="quantity[]"]').val(newQuantity);
            $(this).find('input[name="in_price[]"]').val(giaNhap);
            $(this).find('input[name="out_price[]"]').val(giaBan);
            $(this).find('input[name="into_money[]"]').val(newTotal);


           
            if ($(this).find('td').eq(3).find('input[name="quantity[]"]').length === 0) {
              // Nếu không tồn tại, thêm input vào hàng
              $(this).find('td').eq(3).append(`<input type="hidden" name="quantity[]" value="${newQuantity}"/>`);
            }
            if ($(this).find('td').eq(4).find('input[name="in_price[]"]').length === 0) {
              // Nếu không tồn tại, thêm input vào hàng
              $(this).find('td').eq(4).append(`<input type="hidden" name="in_price[]" value="${giaNhap}"/>`);
            }
            if ($(this).find('td').eq(5).find('input[name="out_price[]"]').length === 0) {
              // Nếu không tồn tại, thêm input vào hàng
              $(this).find('td').eq(5).append(`<input type="hidden" name="out_price[]" value="${giaBan}"/>`);
            }
            if ($(this).find('td').eq(6).find('input[name="into_money[]"]').length === 0) {
              // Nếu không tồn tại, thêm input vào hàng
              $(this).find('td').eq(6).append(`<input type="hidden" name="into_money[]" value="${newTotal}"/>`);
            }

            // Reset form and disable provider if necessary
            clearForm();
            toggleProvider();
            foundDuplicate = true;
            return false; // Exit the loop if duplicate is found
          }
        }
      });

      if (!foundDuplicate) {
        if (isEditMode) {
          // Update existing row if in edit mode
          var row = $("#tb-ds-product tbody tr").eq(editIndex);
          row.find('td').eq(0).text(stt);
          row.find('td').eq(1).text(nameSeries);
          row.find('td').eq(2).text(nameDetail);
          row.find('td').eq(3).text(soLuong);
          row.find('td').eq(4).text(formatNumber(giaNhap));
          row.find('td').eq(5).text(formatNumber(giaBan));
          row.find('td').eq(6).text(formatNumber(thanhTien));

          row.find('input[name="id_series[]"]').val(idSeries);
          row.find('input[name="id_detail[]"]').val(idDetail);
          row.find('input[name="quantity[]"]').val(soLuong);
          row.find('input[name="in_price[]"]').val(giaNhap);
          row.find('input[name="out_price[]"]').val(giaBan);
          row.find('input[name="into_money[]"]').val(thanhTien);


          if (row.find('td').eq(1).find('input[name="id_series[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            row.find('td').eq(1).append(`<input type="hidden" name="id_series[]" value="${idSeries}"/>`);
          }
          if (row.find('td').eq(2).find('input[name="id_detail[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            row.find('td').eq(2).append(`<input type="hidden" name="id_detail[]" value="${idDetail}"/>`);
          }
          if (row.find('td').eq(3).find('input[name="quantity[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            row.find('td').eq(3).append(`<input type="hidden" name="quantity[]" value="${soLuong}"/>`);
          }
          if (row.find('td').eq(4).find('input[name="in_price[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            row.find('td').eq(4).append(`<input type="hidden" name="in_price[]" value="${giaNhap}"/>`);
          }
          if (row.find('td').eq(5).find('input[name="out_price[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            row.find('td').eq(5).append(`<input type="hidden" name="out_price[]" value="${giaBan}"/>`);
          }
          if (row.find('td').eq(6).find('input[name="into_money[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            row.find('td').eq(6).append(`<input type="hidden" name="into_money[]" value="${thanhTien}"/>`);
          }


          // Reset form and disable provider if necessary
          clearForm();
          toggleProvider();
          isEditMode = false;
          editIndex = -1;
          $('#btn-them').text("Thêm"); // Reset button text to "Thêm" after editing
        } else {
          // Add new row if not in edit mode
          var row = `<tr>
                <td>${stt}</td>
                <td>${nameSeries}<input type="hidden" name="id_series[]" value="${idSeries}"/></td>
                <td>${nameDetail}<input type="hidden" name="id_detail[]" value="${idDetail}"/></td>
                <td>${soLuong}<input type="hidden" name="quantity[]" value="${soLuong}"/></td>
                <td>${formatNumber(giaNhap)}<input type="hidden" name="in_price[]" value="${giaNhap}"/></td>
                <td>${formatNumber(giaBan)}<input type="hidden" name="out_price[]" value="${giaBan}"/></td>
                <td>${formatNumber(thanhTien)}<input type="hidden" name="into_money[]" value="${thanhTien}"/></td>
                <td>
                    <button type="button" class="btn btn-primary btn-sua">Sửa</button>
                    <button type="button" class="btn btn-danger btn-xoa">Xóa</button>
                </td>
            </tr>`;

          if (isEditMode && editIndex >= 0) {
            $("#tb-ds-product tbody tr").eq(editIndex).replaceWith(row);
          } else {
            $('#tb-ds-product').find('tbody').append(row);
          }

          // Increment STT and reset form and disable provider if necessary
          STT = $("#tb-ds-product tbody tr").length;
          clearForm();
          toggleProvider();
        }
      }
    });

    $('#tb-ds-product').on('click', '.btn-xoa', function() {
            $(this).closest('tr').remove();
            clearForm();
            toggleProvider();
        });

    function reindexRows() {
      $('#tb-ds-product tbody tr').each(function(index) {
        $(this).find('td:first').text(index + 1);
      });
      STT = $("#tb-ds-product tbody tr").length;
    }

    $('#tb-ds-product').on('click', '.btn-sua', function() {
      $('#btn-them').text("Lưu"); // Đổi nút thành "Lưu" khi nhấn vào nút "Sửa"
      var row = $(this).closest('tr');
      editIndex = row.index(); // Lưu chỉ số của hàng đang được sửa đổi
      var idSeries = row.find('input[name="id_series[]"]').val();
      var idDetail = row.find('input[name="id_detail[]"]').val();
      var soLuong = parseInt(row.find('input[name="quantity[]"]').val());
      var giaNhap = parseFloat(row.find('input[name="in_price[]"]').val());
      var giaBan = parseFloat(row.find('input[name="out_price[]"]').val());

      // Đổ dữ liệu từ hàng cũ vào form chỉnh sửa
      $("#series").val(idSeries);
      $("#productDetails").val(idDetail);
      $("#quantity").val(soLuong);
      $("#in-price").val(giaNhap);
      $("#out-price").val(giaBan);

      isEditMode = true; // Đặt chế độ chỉnh sửa thành true
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

      if ($("#series").val() === null) {
        $("#error-series").text("Vui lòng chọn dòng sản phẩm!").show();
        isValid = false;
      } else {
        $("#error-series").text("").hide();
      }

      if ($("#productDetails").val() === null) {
        $("#error-productDetails").text("Vui lòng chọn dòng sản phẩm!").show();
        isValid = false;
      } else {
        $("#error-productDetails").text("").hide();
      }


      var soLuong = parseFloat($("#quantity").val());

      if (isNaN(soLuong)) {
        $("#error-quantity").text("Vui lòng nhập số lượng").show();
        isValid = false;
      } else if (soLuong <= 0) {
        $("#error-quantity").text("Số lượng không thể là số âm").show();
        isValid = false;
      } else {
        $("#error-quantity").text("").hide();
      }

      var giaNhap = parseFloat($("#in-price").val());
      var giaBan = parseFloat($("#out-price").val());

      if (isNaN(giaNhap)) {
        $("#error-in-price").text("Vui lòng nhập giá nhập!").show();
        isValid = false;
      } else if(giaNhap<=0){
        $("#error-in-price").text("Giá nhập phải lớn hơn 0!").show();
        isValid = false;
      }else{
        $("#error-in-price").text("").hide();
      }

      if (isNaN(giaBan)) {
        $("#error-out-price").text("Vui lòng nhập giá bán!").show();
        isValid = false;
      } else if(giaBan<=0){

        $("#error-out-price").text("Giá bán phải lớn hơn 0!").show();
        isValid = false;
      }else if (giaBan <= giaNhap) {
        $("#error-out-price").text("Giá bán phải lớn hơn giá nhập!").show();
        isValid = false;
      } else {
        $("#error-out-price").text("").hide();
      }

      return isValid;
    }

    function clearForm() {
      $("#series").val("Chọn dòng sản phẩm");
      $("#productDetails").val("Chọn sản phẩm");
      $("#in-price").val("");
      $("#out-price").val("");
      $("#quantity").val("1");
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


  $('#series').change(function() {
    var seriesId = $(this).val();
    if (seriesId) {
      $.ajax({
        url: '/warehouse/getProductDetailsBySeries/' + seriesId,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          $('#productDetails').empty().append('<option selected disabled>Chọn sản phẩm</option>');

          $.each(data.productDetails, function(index, detail) {
            var optionText = detail.product_name + ' - ' + detail.color_name + ' - ' + detail.capacity_name;
            $('#productDetails').append('<option value="' + detail.id + '">' + optionText + '</option>');
          });
        },
        error: function(xhr, status, error) {
          console.log("Có lỗi xảy ra: " + error);
        }
      });
    }
  });
</script>

@endsection