@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3>NHẬP HÓA ĐƠN</h3>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="admin" class="form-label">Nhân viên:</label>
    <input type="text" class="form-control" value="{{Auth::user()->name}}" id="admin" readonly />
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <label for="customer" class="form-label">Khách hàng:</label>
    <select name="customer" class="form-select" id="customer" required>
      <option selected disabled>Chọn khách hàng</option>
      @foreach($listCustomer as $cusTomer)
      <option value="{{$cusTomer->id}}" data-phone="{{$cusTomer->phone}}">{{$cusTomer->name}}</option>
      @endforeach
    </select>
    <span class="error" id="error-customer"></span>
  </div>
</div>
<div class="row">
  <div class="col-md-2">
    <label for="phone" class="form-label">Số điện thoại:</label>
    <input type="text" class="form-control" name="phone" id="phone">
    <span class="error" id="error-phone"></span>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="product" class="form-label">Sản phẩm:</label>
    <select name="product" class="form-select" id="product" required>
      <option selected disabled>Chọn sản phẩm</option>
      @foreach($listProduct as $proDuct)
      <option value="{{$proDuct->id}}">{{$proDuct->name}}</option>
      @endforeach
    </select>
    <span class="error" id="error-product"></span>
  </div>
</div>
<div>
  <label for="product" class="form-label">Chi tiết sản phẩm:</label>
  <div id="chi-tiet-sp"></div>
</div>
<button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
<br>
<br>
<form method="POST" action="{{route('invoice.hd-add-new')}}">
  @csrf
  <div class="table-responsive">
    <table class="table" id="tb-ds-product">
      <thead>
        <tr>
          <th>STT</th>
          <th>Sản phẩm</th>
          <th>Màu sắc</th>
          <th>Dung lượng</th>
          <th>Số lượng</th>
          <th>Giá bán</th>
          <th>Thành tiền</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <input type="hidden" id="nv-id" name="qt" value="{{Auth::user()->id}}" />
  <input type="hidden" id="k-h" name="customer_id" />
  <input type="hidden" id='in-phone' name="in_phone" />

  <div class="col-md-2">
    <button type="submit" class="btn btn-primary" id="luu"><span data-feather="save"></span>Lưu</button>
  </div>
</form>
@endsection

@section('page-js')
<script type="text/javascript">
$(document).ready(function() {
    var STT = 0;
    var selectedItems = [];

    $("#btn-them").click(function() {
        if (!validateInput()) {
            return;
        }
        themVao();

        for (var i = 0; i < selectedItems.length; i++) {
            var item = selectedItems[i];
            var existingRow = findExistingRow(item);
            if (existingRow) {
                // Sản phẩm đã tồn tại, chỉ cập nhật số lượng
                updateExistingRow(existingRow, item);
            } else {
                // Sản phẩm chưa tồn tại, thêm mới
                addNewRow(item);
            }
        }

        // Reset form sau khi thêm
        $("#product").val("Chọn sản phẩm");
        $("#gia-ban").val("");
        $("#so-luong").val("1");
        $("#chi-tiet-sp").html("");
        testNamePhone();

    });

    $('#tb-ds-product').on('click', '#btn-xoa', function() {
        var tr = $(this).closest('tr');
        tr.remove();
        STT--;
        testNamePhone();
    });

    $("#product, #so-luong, #gia-ban, #customer").change(function() {
        $(`#error-${this.id}`).text(""); // Xóa thông báo khi người dùng thay đổi lựa chọn
    });

    $("#customer").click(function() {
        $("#k-h").val(this.value);
    });

    $('#phone').keyup(function() {
        $('#in-phone').val($(this).val());
    });

    $('#customer').click(function() {
        var selectedOption = $(this).find(':selected');
        var soDienThoai = selectedOption.data('phone');
        $('#in-phone').val(soDienThoai);
        $('#phone').val(soDienThoai);
    });

    $('#product').change(function() {
        var spId = $(this).val();
        $.ajax({
            method: 'GET',
            url: "{{ route('get-product-ajax') }}",
            data: {
                product_id: spId
            },
            success: function(response) {
                $('#chi-tiet-sp').html(response);
            }
        });
    });

    function findExistingRow(item) {
        var existingRow = null;
        $('#tb-ds-product tbody tr').each(function() {
            var spID = $(this).find('input[name="spID[]"]').val();
            var msID = $(this).find('input[name="msID[]"]').val();
            var dlID = $(this).find('input[name="dlID[]"]').val();
            if (spID == item.prdId && msID == item.MauSacId && dlID == item.DungLuongId) {
                existingRow = $(this);
                return false; // Dừng vòng lặp khi tìm thấy sản phẩm trùng
            }
        });
        return existingRow;
    }

    function updateExistingRow(existingRow, item) {
        var soLuongHienTai = parseInt(existingRow.find('td').eq(4).text());
        var soLuongMoi = parseInt(item.soLuong);
        var giaBan = parseInt(item.giaBan);
        var maxQuantity = parseInt(existingRow.find('input[name="quantity[]"]').attr('max'));

        if (soLuongHienTai + soLuongMoi > maxQuantity) {
            alert("Số lượng mua phải bé hơn hoặc bằng số lượng tồn kho!");
            return;
        }
        if(soLuongMoi <=0 || isNaN(soLuongMoi)){
            alert("Số lượng phải lớn hơn 0!");
            return;
        }
        var newQuantity = soLuongHienTai + soLuongMoi; 
        var toTalNew = newQuantity * giaBan;

        existingRow.find('input[name="quantity[]"]').val(newQuantity.toString());
        existingRow.find('td').eq(4).text(newQuantity.toString());
        existingRow.find('input[name="total[]"]').val(toTalNew.toString());
        existingRow.find('td').eq(6).text(formatNumber(toTalNew).toString());

        if (existingRow.find('td').eq(4).find('input[name="quantity[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            existingRow.find('td').eq(4).append(`<input type="hidden" name="quantity[]" value="${newQuantity}" max="${maxQuantity}"/>`);
        }
        if (existingRow.find('td').eq(6).find('input[name="total[]"]').length === 0) {
            // Nếu không tồn tại, thêm input vào hàng
            existingRow.find('td').eq(6).append(`<input type="hidden" name="total[]" value="${toTalNew}"/>`);
        }
    }

    function testNamePhone() {
        if (STT > 0) {
            $('#customer').prop('disabled', true);
            $('#phone').prop('readonly', true);
        } else {
            $('#customer').prop('disabled', false);
            $('#phone').prop('readonly', false);
        }
    }

    function themVao() {
        selectedItems = []; // Reset mảng trước khi chọn mua
        $('#table-hd-ctsp tbody tr').each(function() {
            var checkBox = $(this).find('#buy-id');
            if (checkBox.is(':checked')) {
                var productId = $(this).find('#product-id').val();
                var mauSac = $(this).find('#td-color').text();
                var dungLuong = $(this).find('#td-capacity').text();
                var soLuong = $(this).find('#quantity-id').val();
                var giaBan = $('#price-id', this).val();
                var MauSacId = $('#color-id', this).val();
                var DungLuongId = $('#capacity-id', this).val();
                var maxQuantity = parseInt($(this).find('#quantity-id').attr('max'));

                // Check if quantity is valid
                if (parseInt(soLuong) > maxQuantity) {
                    alert("Số lượng mua phải bé hơn hoặc bằng số lượng tồn kho.");
                    return;
                }
                
                if (parseInt(soLuong) <= 0 || isNaN(soLuong)) {
                    alert("Số lượng mua phải lớn hơn 0");
                    return;
                }

                selectedItems.push({
                    prdId: productId,
                    mauSac: mauSac,
                    dungLuong: dungLuong,
                    soLuong: soLuong,
                    giaBan: giaBan,
                    MauSacId: MauSacId,
                    DungLuongId: DungLuongId,
                    maxQuantity: maxQuantity
                });
            }
        });
    }

    function validateInput() {
        var isValid = true;
        if ($("#k-h").val() === "" || $("#customer").val() === null) {
            $("#error-customer").text("Vui lòng chọn tên khách hàng!");
            isValid = false;
        } else {
            $("#error-customer").text("");
        }

        if ($("#in-phone").val() === null) {
            $("#error-phone").text("Vui lòng nhập số điện thoại!");
            isValid = false;
        } else {
            $("#error-phone").text("");
        }
        if ($("#product").val() === null) {
            $("#error-product").text("Vui lòng chọn sản phẩm!");
            isValid = false;
        } else {
            $("#error-product").text("");
        }

        $('input[name="quantity"]').each(function() {
            var maxQuantity = parseInt($(this).attr('max'));
            var currentQuantity = parseInt($(this).val());

            if (currentQuantity > maxQuantity) {
                alert("Số lượng mua phải bé hơn hoặc bằng số lượng tồn kho.");
                $(this).val(maxQuantity);
                isValid = false;
            }
        });
        return isValid;
    }

    function addNewRow(item) {
        var stt = $("#tb-ds-product tbody tr").length + 1;
        STT = stt;
        var idNV = $("#admin").find(":selected").val();
        var idKH = $("#customer").find(":selected").val();
        var soDT = $('#phone').val();
        $('#k-h').val(idKH);
        $('#phone').val(soDT);
        var tenSP = $("#product").find(":selected").text();
        var idSP = $("#product").find(":selected").val();
        var msID = item.MauSacId;
        var dlID = item.DungLuongId;
        var mauSac = item.mauSac;
        var dungLuong = item.dungLuong;
        var soLuong = item.soLuong;
        var giaBan = item.giaBan;
        var thanhTien = soLuong * giaBan;

        var row = `<tr>
            <td>${stt}</td>
            <td>${tenSP}<input type="hidden" name="spID[]" value="${idSP}"/></td>
            <td>${mauSac}<input type="hidden" name="msID[]" value="${msID}"/></td>
            <td>${dungLuong}<input type="hidden" name="dlID[]" value="${dlID}"/></td>
            <td>${soLuong}<input type="hidden" name="quantity[]" value="${soLuong}" max="${item.maxQuantity}"/></td>
            <td>${formatNumber(giaBan)}<input type="hidden" name="price[]" value="${giaBan}"/></td>
            <td>${formatNumber(thanhTien)}<input type="hidden" name="total[]" value="${thanhTien}"/></td>
            <td><button type="button" class="btn btn-danger" id="btn-xoa">Xóa</button></td>
          </tr>`;

        $('#tb-ds-product').find('tbody').append(row);
    }

    function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
});

</script>
@endsection