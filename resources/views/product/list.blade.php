@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH DÒNG SẢN PHẨM</h3>
    <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Sản phẩm đã xóa</button>
</div>
<div class="custom-search-container">
    <form action="{{ route('product.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />
@if(isset($listProduct) && $listProduct->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
    <tr class="title_sp">
        <th>Tên sản phẩm</th>
        
        <th>Mô tả</th>  
        <th>Hãng sản phẩm</th>
        <th>Dòng sản phẩm</th>
        <th>Tác vụ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listProduct as $Product)
    <tr>
        <td>{{ $Product->name }}</td>
        <td>{{ $Product->description }}</td>
        <td>{{ $Product->brand->name }}</td>
        <td>{{ $Product->product_series->name }}</td>
        <td class="chuc-nang">
            <a href="{{ route('product.update-images', ['id' => $Product->id]) }}" class="btn btn-outline-info"><i class="fas fa-camera"></i></a> |
            
            <a href="{{ route('product.update', ['id' => $Product->id]) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> |
            <a href="{{ route('product.detail', ['id' => $Product->id]) }}" class="btn btn-outline-info"><i class="fas fa-info-circle"></i></a> |
            <a href="{{ route('product.delete', ['id' => $Product->id]) }}" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a> 
        </td>
    <tr>
    @endforeach
    </tbody>
</table> 
{{ $listProduct->links('vendor.pagination.default') }}
@else
    <span class="error">Không có sản phẩm nào!</span>
@endif
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Danh sách sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      @if(isset($listProductDelete) && $listProductDelete->isNotEmpty())
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($listProductDelete as $proDuct)
                    <tr>
                        <td>{{$proDuct->name}}</td>
                        <td><a href="{{ route('product.restore',['id'=>$proDuct->id])}}">Khôi phục</a>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      @else
      <h6 class="error">Không có sản phẩm nào đã xóa!</h6>
      @endif
    </div>
</div>

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