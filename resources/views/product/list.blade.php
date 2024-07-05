@extends('master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3>DANH SÁCH SẢN PHẨM</h3>
  <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa fa-trash"></i>Sản phẩm đã xóa</button>
</div>
<div class="custom-search-container">
  <input type="text" id="search-input" class="search-input" name="query" placeholder="Tìm kiếm...">
  <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
</div>
<x-notification />
<div id="table-responsive" class="table-responsive">
  @include('product.table', ['listProduct' => $listProduct])
</div>
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



@section('page-js')
<script type="text/javascript">
  $(document).ready(function() {

    $('#search-button').click(function(e) {
      e.preventDefault();
      performSearch();
    });

    var typingTimer;
    var doneTypingInterval = 500;

    $('#search-input').on('keyup', function() {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(performSearch, doneTypingInterval);
    });

    function performSearch() {
      var query = $('#search-input').val();
      $.ajax({
        url: '{{ route("product.search") }}',
        type: 'GET',
        data: {
          query: query
        },
        success: function(response) {
          $('#table-responsive').html(response.html);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    }

  })
</script>
@endsection