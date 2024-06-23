@extends('master')

@section('content')
<head>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h3>THÊM MỚI TIN TỨC</h3>
            </div>
            <form method="POST" action="{{route('news.hd-add-new')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-6">
                <label for="admin_id" class="form-label">Tác giả</label>
                <input type="text" class="form-control" value="{{Auth::user()->name}}" id="admin_id" name="admin_id" readonly />
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                        <span class="error-message"> {{ $message }} </span>
                        @enderror
                    </div>
                </div>
                        <textarea name="content"></textarea>
                <script>
                    CKEDITOR.replace('content');
                </script>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
@endsection