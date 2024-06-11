@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH SẢN PHẨM</h3>
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Sản phẩm đã xóa</button>
</div>
@if(session('Error'))
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <div> 
              {{session('Error')}}
        </div>
    </div>
@endif
@if(session('Success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div> 
              {{session('Success')}}
        </div>
    </div>
@endif
@if(isset($listProduct) && $listProduct->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
    <tr class="title_sp">
        <th>Tên sản phẩm</th>
        <th>Mô tả</th>  
        <th>Hãng sản phẩm</th>
        <th>Tác vụ</th>
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
                  @foreach($listProductDelete as $productDelete)
                    <tr>
                        <td>{{$productDelete->name}}</td>
                        <td><a href="{{ route('product.restore',['id'=>$productDelete->id])}}">Khôi phục</a> | <a href="#">Chi tiết</a></td>
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