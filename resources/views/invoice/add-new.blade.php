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
      @foreach($proDuct->product_detail as $deTail)
      <option value="{{$proDuct->id}}" id="product">{{$proDuct->name}}</option>
      @endforeach
      @endforeach
    </select>
    <span class="error" id="error-product"></span>
  </div>
</div>


<div class="col-md-6">
  <label for="product" class="form-label">Chi tiết sản phẩm:</label>
  <div id="chi-tiet-sp"></div>
</div>



<button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
<br>
<form method="POST" action="{{route('invoice.hd-add-new')}}">
  @csrf
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="tb-ds-product">
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
  <input type="" id="nv-id" name="qt" value="{{Auth::user()->id}}"/>
  <input type="" id="k-h" name="kh"/>
  <input type="" id='hd-phone' name="hd_phone"/>
  <input type="" id='hd-product' name="hd_product"/>
  <div class="col-md-2">
    <button type="submit" class="btn btn-primary" id="luu"><span data-feather="save"></span>Lưu</button>
  </div>
</form>
@endsection

@section('page-js')
<script type="text/javascript">
  $(document).ready(function() {
    var STT=0;
    $("#btn-them").click(function() {
      
      if ($("#k-h").val() === "" || $("#customer").val() == "Chọn khách hàng") {
        $("#error-customer").text("Vui lòng chọn tên khách hàng!");
        return;
      } else {
        $("#error-customer").text("");
      } 

      if ($("#phone").val() === "") {
        $("#error-phone").text("Vui lòng nhập số điện thoại!");
        return;
      } else {
        $("#error-phone").text("");
      }
      if ($("#product-id").val() === "" || $("#product").val() == "Chọn sản phẩm") {
        $("#error-product").text("Vui lòng chọn sản phẩm!");
        return;
      } else {
        $("#error-product").text("");
      }
      
      themVao();
      
      for (var i = 0; i < selectedItems.length; i++) {
        var item = selectedItems[i];
        var stt = $("#tb-ds-product tbody tr").length + 1;
        STT=stt;
        var idNV = $("#admin").find(":selected").val();
        var idKH = $("#customer").find(":selected").val();
        var soDT=$('#phone').val();
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
        var thanhTien = soLuong*giaBan;
        
      var row = `<tr>
      <td>${stt}</td>
      <td>${tenSP}<input type="hidden" name="spID[]" value="${idSP}"/></td>
      <td>${mauSac}<input type="hidden" name="msID[]" value="${msID}"/></td>
      <td>${dungLuong}<input type="hidden" name="dlID[]" value="${dlID}"/></td>
      <td>${soLuong}<input type="hidden" name="quanlity[]" value="${soLuong}"/></td>
      <td>${giaBan}<input type="hidden" name="price[]" value="${giaBan}"/></td>
      <td>${thanhTien}<input type="hidden" name="total[]" value="${thanhTien}"/></td>
      <td>
        <button type="button" class="btn btn-danger" id="btn-xoa">Xóa</button>
      </td>
      </tr>`;
      $('#tb-ds-product').find('tbody').append(row);
      }
      $("#product").val("Chọn sản phẩm");
      $("#gia-ban").val("");
      $("#so-luong").val("1");
      $("#product-id").val("");
     
      
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


    $("#product").click(function() {
      $("#product-id").val(this.value);
    });

    $("#customer").click(function() {
      $("#k-h").val(this.value);
    });
    
     $('#customer').click(function() {
        var selectedOption = $(this).find(':selected');
        var soDienThoai = selectedOption.data('phone');
        console.log(soDienThoai)
        $('#phone').val(soDienThoai);
    });

    $('#product').change(function() {
      var spId = $('#product').find(':selected').val();
      $.ajax({
          method: 'GET',
          url: "{{route('invoice.get-product')}}",
          data: {
            productId: spId
          }
        })
        .done(function(response) {
          $('#chi-tiet-sp').html(response);
          var soLuongMax = $('#so-luong-ct').attr('max'); // Lấy giá trị max từ thuộc tính max của ô nhập số lượng
          $('#so-luong-ct').attr('min', 1); // Cập nhật giá trị min là 1
          $('#so-luong-ct').val(1); // Đặt giá trị mặc định là 1
        });
    });
    
    function testNamePhone()
    {
     
      if (STT > 0) {
        $('#customer').prop('disabled', true);
        $('#phone').prop('readonly', true);
        
      }
      else{
        $('#customer').prop('disabled', false);
        $('#phone').prop('readonly', false);
        
      }
    }

    function themVao() {
    selectedItems = [];  // Reset mảng trước khi chọn mua
    // Iterate through each row in the first table
        $('#table-hd-ctsp tbody tr').each(function() {
            var checkBox = $(this).find('#buy-id');
            if (checkBox.is(':checked')) {
                var stt = $("#table-hd-ctsp tbody tr").length + 1;
                var mauSac = $(this).find('#td-color').text();
                var dungLuong = $(this).find('#td-capacity').text();
                var soLuong = $(this).find('#quanlity-id').val();
                var giaBan = $('#price-id', this).val();
                var MauSacId = $('#color-id', this).val();
                var DungLuongId = $('#capacity-id', this).val();
                // Add selected item to the array
                selectedItems.push({
                    stt: stt,
                    mauSac: mauSac,
                    dungLuong: dungLuong,
                    soLuong: soLuong,
                    giaBan: giaBan,
                    MauSacId:MauSacId,
                    DungLuongId:DungLuongId
                });
            }
        });
         
          };
  });
</script>
@endsection