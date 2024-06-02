@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h3>THÊM MỚI DUNG LƯỢNG</h3>
            </div>
            <form method="POST" action="{{route('capacity_color.hd-add-new-capacity')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nhập dung lượng</label>
                        <input type="text" class="form-control" name="name">
                    </div>     
                </div>    
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
@endsection