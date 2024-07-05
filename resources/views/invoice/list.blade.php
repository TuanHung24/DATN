@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>DANH SÁCH HÓA ĐƠN</h3>
</div>
<div class="custom-search-container">
    <input type="text" id="search-input" class="search-input" name="query" value="{{ $query ?? '' }}" placeholder="Tìm kiếm...">
    <button type="button" id="search-button" class="search-button"><i class="fa fa-search"></i></button>
</div> 
<x-notification/>
<div id="table-responsive" class="table-responsive">
    @include('invoice.table', ['listInvoice' => $listInvoice])
</div>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function(){

        $('.cancel-btn').on('click', function(){
        var invoiceId = $(this).data('id');
        var confirmHuy = false; 

        if (!confirmHuy) {
            var confirmXoa = confirm("Bạn chắc chắn có muốn hủy hóa đơn này không?");

            if (confirmXoa) {
                window.location.href = "{{ route('invoice.update-status-cancel', '') }}/" + invoiceId;
            } else {
                window.location.href = "{{ route('invoice.list') }}";
            }
        }

        
    
    });

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
                url: '{{ route("invoice.search") }}',
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
    });
</script>
@endsection