@extends('master')

@section('content')
<head>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT TIN TỨC</h3>
</div>
@if(session('Error'))
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <div>
        {{session('Error')}}
    </div>
</div>
@endif
<form method="POST" action="{{ route('news.hd-update', ['id'=> $news->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
    <div class="col-md-6">
                <label for="admin_id" class="form-label">Tác giả</label>
                <input type="text" class="form-control" value="{{$news->admin->name}}" id="admin_id" name="admin_id" readonly />
    </div>
    <div class="col-md-6">
         <label for="name" class="form-label">Title</label>
         <input type="text" class="form-control"value="{{old('title',$news->title)}}" name="title">
    </div>
</div>
<textarea name="content">{{old('content',$news->content)}}</textarea>
                <script>
                    CKEDITOR.replace('content');
                </script>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
</form>
@endsection