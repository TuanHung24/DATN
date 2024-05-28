@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h4>NHẬP HÀNG</h4>
</div>
<div class="row">
  <div class="col-md-6"> 
    <label for="nha_cung_cap" class="form-label">Chọn nhà cung cấp:</label>
      <select for="nha_cung_cap" class="form-select" id="nha-cung-cap">
        <option selected disabled>Chọn nhà cung cấp</option>
          @foreach($dsNhaCungCap as $nhaCungCap)
            <option value="{{$nhaCungCap->id}}" id="nha_cung_cap">{{$nhaCungCap->ten}}</option>
          @endforeach
      </select>
    <span class="error-message" id="error-nha-cung-cap"></span>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="san_pham" class="form-label">Sản phẩm:</label>
      <select name="san_pham" class="form-select" id="san-pham">
        <option selected disabled>Chọn sản phẩm</option>
          @foreach($dsSanPham as $sanPham)
            <option value="{{$sanPham->id}}">{{$sanPham->ten}}</option>
          @endforeach
      </select>
    <span class="error-message" id = "error-san-pham"></span>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="mau_sac" class="form-label">Màu sắc:</label>
    <select name="mau_sac" class="form-select" id="mau-sac">
      <option selected disabled>Chọn màu</option>
      @foreach($dsMauSac as $mauSac)
      <option value="{{$mauSac->id}}">{{$mauSac->ten}}</option>
      @endforeach
    </select>

            <span class="error-message" id ="error-mau-sac"></span>

  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="dung_luong" class="form-label">Dung lượng:</label>
    <select name="dung_luong" class="form-select" id="dung-luong">
      <option selected disabled>Chọn dung lượng</option>
      @foreach($dsDungLuong as $dungLuong)
      <option value="{{$dungLuong->id}}">{{$dungLuong->ten}}</option>
      @endforeach
    </select>

            <span class="error-message" id="error-dung-luong"></span>

  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="so_luong" class="form-label">Số lượng:</label>
    <input type="number" class="form-control" name="so_luong" id="so-luong" value="1">

            <span class="error-message"></span>

  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="gia_nhap" class="form-label">Giá nhập:</label>
    <input type="number" class="form-control" name="gia_nhap" id="gia-nhap">

            <span class="error-message" id="error-gia-nhap"></span>

  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label for="gia_ban" class="form-label">Giá bán:</label>
    <input type="number" class="form-control" name="gia_ban" id="gia-ban">

            <span class="error-message" id = 'error-gia-ban'></span>

  </div>
</div>
<button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
<br>
<form method="POST" action="{{route('nhap-hang.xl-them-moi')}}">
  @csrf
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="tb-ds-san-pham">
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
  <input type="hidden" id="ncc-id" name="ncc" />
  <input type="hidden" id="sp-id" name="sp" />
  <input type="hidden" id="mau-id" name="mau" />
  <input type="hidden" id="dl-id" name="dl" />
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
      var stt = $("#tb-ds-san-pham tbody tr").length + 1;
      STT=stt;
      var tenSP = $("#san-pham").find(":selected").text();
      var idSP = $("#san-pham").find(":selected").val();
      var dungLuong = $("#dung-luong").find(":selected").text();
      var idDL = $("#dung-luong").find(":selected").val();
      var mauSac = $("#mau-sac").find(":selected").text();
      var idMS = $("#mau-sac").find(":selected").val();
      var soLuong = $("#so-luong").val();
      var giaNhap = $("#gia-nhap").val();
      var giaBan = $("#gia-ban").val();
      var thanhTien = soLuong * giaNhap;

      if (!validateInput()) {
        return;
       
      }
      
     
      var row = `<tr>
      <td>${stt}</td>
      <td>${tenSP}<input type="hidden" name="idSP[]" value="${idSP}"/></td>
      <td>${dungLuong}<input type="hidden" name="idDungLuong[]" value="${idDL}"/></td>
      <td>${mauSac}<input type="hidden" name="idMauSac[]" value="${idMS}"/></td>
      <td>${soLuong}<input type="hidden" name="soLuong[]" value="${soLuong}"/></td>
      <td>${giaNhap}<input type="hidden" name="giaNhap[]" value="${giaNhap}"/></td>
      <td>${giaBan}<input type="hidden" name="giaBan[]" value="${giaBan}"/></td>
      <td>${thanhTien}<input type="hidden" name="thanhTien[]" value="${thanhTien}"/></td>
      <td>
        <button type="button" id="btn-xoa" class="btn btn-danger">Xóa</button>
      </td>
      </tr>`;

      $('#tb-ds-san-pham').find('tbody').append(row);
      $("#san-pham").val("Chọn sản phẩm");
      $("#dung-luong").val("Chọn dung lượng");
      $("#mau-sac").val("Chọn màu");
      $("#gia-nhap").val("");
      $("#gia-ban").val("");
      $("#so-luong").val("1");
      isValid=false;
      
      Test();
      
      
      
    });
    function Test(){
      if(STT>0){
        $('#nha-cung-cap').prop('disabled', true);
      }
      else{
        $('#nha-cung-cap').prop('disabled', false);
      }
    }
    
    $('#tb-ds-san-pham').on('click', '#btn-xoa', function() {
      var tr = $(this).closest('tr');
      tr.remove();
      STT--;
      Test();
    });
    
    $("#nha-cung-cap, #san-pham, #mau-sac, #dung-luong, #so-luong, #gia-nhap, #gia-ban").change(function() {
      $(`#error-${this.id}`).hide();
    });

    $("#nha-cung-cap").click(function() {
      $("#ncc-id").val(this.value);
    });

    $("#san-pham").click(function() {
      $("#sp-id").val(this.value);
    });

    $("#mau-sac").click(function() {
      $("#mau-id").val(this.value);
    });

    $("#dung-luong").click(function() {
      $("#dl-id").val(this.value);
    });

    function validateInput() {
        isValid =true;
        if ($("#ncc-id").val() === "" || $("#ncc-id").val() === "Chọn nhà cung cấp") {
          $("#error-nha-cung-cap").text("Vui lòng chọn nhà cung cấp!");
          isValid = false;
        } else {
          $("#error-nha-cung-cap").text("");

        }

        if ($("#sp-id").val() === "" || $("#sp-id").val() === "Chọn sản phẩm") {
          $("#error-san-pham").text("Vui lòng chọn sản phẩm!");
          isValid = false;
        } else {
          $("#error-san-pham").text("");

        }

        if ($("#mau-id").val() === "" || $("#mau-id").val() === "Chọn màu") {
          $("#error-mau-sac").text("Vui lòng chọn màu!");
          isValid = false;
        } else {
          $("#error-mau-sac").text("");

        }

        if ($("#dl-id").val() === "" || $("#dl-id").val() === "Chọn dung lượng") {
          $("#error-dung-luong").text("Vui lòng chọn dung lượng!");
          isValid = false;

        } else {
          $("#error-dung-luong").text("");

        }
        var giaNhap = parseFloat($("#gia-nhap").val()); // Xác định giá nhập từ trường nhập liệu
        var giaBan = parseFloat($("#gia-ban").val()); // Xác định giá bán từ trường nhập liệu
       
        if (isNaN(giaNhap)) {
          $("#error-gia-nhap").text("Vui lòng nhập giá nhập!");
          isValid = false;

        } else {
          $("#error-gia-nhap").text("");

        }
       
       
        if ( isNaN(giaBan)) {
          $("#error-gia-ban").text("Vui lòng nhập giá bán!");
          isValid = false;
        } else {
            
        if (giaBan <= giaNhap) {
          $("#error-gia-ban").text("Giá bán phải lớn hơn giá nhập!");
          isValid = false;
        } else {
          $("#error-gia-ban").text("");
        }
      }
        return isValid;
      }
  });
</script>
@endsection