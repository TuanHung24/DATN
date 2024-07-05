@extends('master')

@section('content')



<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>LOGO</h3>
</div>
<x-notification />

<div class="md fade" id="exampleModal" tabindex="-1" aria-labelledby="examplemdLabel" aria-hidden="true">
    <div class="md-dialog">
        <div class="md-content">
            <div class="md-header">
                <h5 class="md-title" id="examplemdLabel">Cập nhật Logo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="md" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('logo.update',['id'=>$loGo->id]) }}" id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="md-body">
                    <input type="file" name="logo" id="file" accept="image/*" required>
                </div>
                <div class="md-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalButton">Thoát</button>&nbsp;&nbsp;
                    <button  class="btn btn-primary" id="savemdButton">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
               
                <th>Hình ảnh logo</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                
                <td> <img type="img_url" class="slide" name="img_url" src="{{asset($loGo->img_url)}}"> </td>
                <td>
                <a id="showModalButton" class="btn btn-outline-primary" title="Cập nhật"><i class="fas fa-edit"></i></a>
                
                </td>
            </tr>
          
        </tbody>
    </table>
    
</div>




<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH SLIDE</h3>
</div>
@if(isset($listSlide) && $listSlide->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th id='th-sp'>Sản Phẩm</th>
                <th>Hình ảnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listSlide as $slide)
            <tr>
                <td>{{ $slide->product->name ?? '' }}</td>
                <td> <img type="img_url" class="slide" name="img_url" src="{{asset($slide->img_url)}}"> </td>
                <td>
                <a href="{{ route('slide-show.update', ['id' => $slide->id]) }}" title="Cập nhật" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> | 
                <a href="{{ route('slide-show.delete', ['id' => $slide->id]) }}" title="Xóa" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $listSlide->links('vendor.pagination.default') }}
</div>
@else
    <span class="error">Không có Slideshow nào!</span>
@endif





@endsection
@section('page-js') 
<script type="text/javascript">
    $(document).ready(function() {
        $('#showModalButton').click(function() {
        $('#exampleModal').addClass('show');
    });
    $('#closeModalButton').click(function() {
        $('#exampleModal').removeClass('show');
    });

    })
</script>
@endsection

