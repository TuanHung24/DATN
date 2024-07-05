@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH BÌNH LUẬN</h3>
</div>
<div class="custom-search-container">
    <form action="{{ route('comment.search') }}">
        <input type="text" id="search-input" class="search-input" name="query" value="{{$query??''}}" placeholder="Tìm kiếm...">
        <button type="submit" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
    </form>
</div>
<x-notification />
@if(isset($listComment) && $listComment->isNotEmpty())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Sản Phẩm</th>
                <th>Bình luận</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listComment as $Comment)
            <tr>
                <td>
                    @php
                    $imgUrl = $Comment->product->imgProductByColor($Comment->color_id)->first()->img_url ?? '';
                    @endphp
                    @if($imgUrl)
                    <img src="{{ asset($imgUrl) }}" class="product-image" />
                    @else
                    <span class="text-danger">Hình ảnh không có sẵn cho màu này</span>
                    @endif
                    <div class="product-name">{{ $Comment->product->name }} - {{ $Comment->color->name }} - {{ $Comment->capacity->name }}</div>
                </td>
                <td class="comment-container">
                    <div class="comment-section">
                        <strong class="comment-author">{{ $Comment->customer->name }}<span class="comment-date">{{ \Carbon\Carbon::parse($Comment->date)->format('d/m/Y H:i') }}</span></strong>
                        
                        <div class="comment-content">{{ $Comment->content }}</div>
                    </div>
                    @foreach($Comment->comment_detail as $detail)
                    <div class="comment-detail-section">
                        <strong class="comment-author">{{ $detail->admin->name }} <span class="comment-date">{{ \Carbon\Carbon::parse($detail->date)->format('d/m/Y H:i') }}</span></strong>
                        
                        <div class="comment-detail-content">{{ $detail->content }}</div>
                    </div>
                    @endforeach
                </td>


                <td>
                    @if(isset($Comment->comment_detail) && $Comment->comment_detail->count() > 0)
                    <button class="btn btn-success"><i class="fa-solid fa-reply"></i>Đã trả lời</button>
                    @else
                    <button class="btn btn-primary showModalButton" data-id="{{ $Comment->id }}"><i class="fa-solid fa-reply"></i> Trả lời</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <div class="md fade" id="exampleModal" tabindex="-1" aria-labelledby="examplemdLabel" aria-hidden="true">
        <div class="md-dialog">
            <div class="md-content">
                <div class="md-header">
                    <h5 class="md-title" id="examplemdLabel">Trả lời bình luận</h5>
                </div>
                <div class="md-body">
                    <div class="comment-label">Khách hàng:
                    <strong class="comment-author" id="md-customer-name"></strong></div>
                    <div class="comment-label">Nội dung:</div>
                    <div class="comment-content" id="md-comment-content"></div>
                    <form method="POST" action="{{ route('comment.hd-rep') }}" id="replyForm">
                        @csrf
                        <input type="hidden" name="comment_id" id="comment_id">
                        <input type="hidden" name="admin_id" id="admin-id" value="{{Auth::user()->id}}">
                        <textarea class="content-admin" name="reply_content"></textarea>
                        <div class="md-footer">
                            <button type="button" class="btn btn-secondary" id="closeModalButton">Thoát</button>&nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary" id="savemdButton">Trả lời</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{ $listComment->links('vendor.pagination.default') }}
</div>
@else
<span class="error">Không có bình luận nào!</span>
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



        $('.showModalButton').click(function() {
            var commentId = $(this).data('id');

            $.ajax({
                url: '/comment/rep/' + commentId,
                type: 'GET',
                success: function(response) {
                    $('#md-customer-name').text(response.customer.name);
                    $('#md-comment-content').text(response.content);
                    $('#comment_id').val(response.id);

                    $('#exampleModal').addClass('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#closeModalButton').click(function() {
            $('#exampleModal').modal('hide');
        });

    })
</script>
@endsection