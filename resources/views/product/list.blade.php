@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH SẢN PHẨM</h3>
</div>
@if(isset($listProduct) && $listProduct->isNotEmpty())
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
    <tr class="title_sp">
        <th>Tên sản phẩm</th>
        <th>Mô tả</th>  
        <th>Hãng sản phẩm</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listProduct as $Product)
    <tr>
        <td>{{ $Product->name }}</td>
        <td>{{ $Product->description }}</td>
        <td>{{ $Product->brand->name }}</td>
        <td class="chuc-nang">
            <a href="{{ route('product.detail', ['id' => $Product->id]) }}" class="btn btn-outline-info"><span data-feather="chevrons-right"></span>Chi tiết</a> |
            <a href="{{ route('product.update', ['id' => $Product->id]) }}" class="btn btn-outline-primary"><span data-feather="edit"></span> Cập nhật</a> |
            <a href="{{ route('product.delete', ['id' => $Product->id]) }}" class="btn btn-outline-danger"><span data-feather="trash-2"></span>Xóa</a>
        </td>
    <tr>
    @endforeach
    </tbody>
</table> 
@else
    <h6>Không có sản phẩm nào!</h6>
@endif
@endsection



<!-- @section('page-js')
<script type="text/javascript">
    $(document).ready(function(){
        $("#popupButton").click(function() {
      showPopup();
    });

    $("#closePopupButton").click(function() {
      closePopup();
    });

    function showPopup() {
      // Hiển thị form popup
      $("#popupForm").show();

      // Tạo và hiển thị màn nền mờ
      $("<div>").addClass("backdrop").on("click", closePopup).appendTo("body");
    }

    function closePopup() {
      // Ẩn form popup
      $("#popupForm").hide();

      // Loại bỏ màn nền mờ
      $(".backdrop").remove();
    }

    $("#myPopupForm").submit(function(event) {
      event.preventDefault();

      // Lấy dữ liệu từ form
      let formData = new FormData(this);

      // Gửi dữ liệu sử dụng AJAX
      $.ajax({
        url: 'url-xử-lý',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          console.log(data);
          closePopup();
        },
        error: function(error) {
          console.error('Lỗi:', error);
        }
      });
    });

    })
</script>
 -->