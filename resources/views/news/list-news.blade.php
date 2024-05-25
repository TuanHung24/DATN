@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 >DANH SÁCH NHÂN VIÊN</h3>
</div>

<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Title</td>
                <th>Nội dung</th>
            </tr>
        </thead>
        @foreach($listNews as $News)
        <tr>
            <td>{{ $News->title }}</td>
            <td>{!! $News->content !!}</td>
            
            
        <tr>
        @endforeach
    </table>
</div>
@endsection