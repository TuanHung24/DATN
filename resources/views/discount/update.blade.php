@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>CẬP NHẬT KHUYẾN MÃI</h3>
</div>
<div class="row">
    <div class="col-md-4">
        <label for="name" class="form-label">Tên khuyến mãi</label>
        <input type="text" class="form-control" name="name" id="name" value="{{old('name',$disCount->name)}}">
    </div>
    <span class="error" id="error-name"></span>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="date-start" class="form-label">Ngày bắt đầu</label>
        <input type="datetime-local" class="form-control" name="date_start" id="date-start" value="{{old('date_start',$disCount->date_start)}}">
        <span class="error" id="error-date-start"></span>
    </div>
    <div class="col-md-6">
        <label for="date-end" class="form-label">Ngày kết thúc</label>
        <input type="datetime-local" class="form-control" name="date_end" id="date-end" value="{{old('date_end',$disCount->date_start)}}">
        <span class="error" id="error-date-end"></span>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <label for="percent" class="form-label">Khuyến mãi</label>
        <input type="number" class="form-control" name="percent" id="percent" value="{{old('percent',$disCount->percent)}}">
        <span class="error" id="error-percent"></span>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <label>Tìm kiếm</label>
        <select name="product" class="form-select" id="product">
            <option selected disabled>Chọn sản phẩm</option>
            @foreach($listProduct as $proDuct)
            <option value="{{$proDuct->id}}">{{$proDuct->name}}</option>
            @endforeach
        </select>
        
    </div>
</div>
<label for="product" class="form-label">Chi tiết sản phẩm:</label> <input type="checkbox" id="checkbox-all" hidden/><label hidden>Chọn tất cả</label>
<div id="chi-tiet-sp"></div>
<div class="col-md-2">
    <button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
</div>
<br/>
<label class="form-label">Các sản phẩm đã áp dụng khuyến mãi:</label>
<form method="POST" action="{{route('discount.hd-update',['id'=>$disCount->id])}}">
    @csrf
    <div class="table-responsive">
        <table class="table table-sm" id="tb-ds-product">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Màu sắc</th>
                    <th>Dung lượng</th>
                    <th>Số lượng</th>
                    <th>Giá gốc</th>
                    <th>Giảm giá(%)</th>
                    <th>Giá đã giảm</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="hd-name" name="discount_name" />
    <input type="datetime-local" id="hd-date-start" name="date_start" hidden />
    <input type="datetime-local" id='hd-date-end' name="date_end" hidden />

    <input type="hidden" id='hd-percent' name="percent_all" />
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary" id="luu"><span data-feather="save"></span>Lưu</button>
    </div>
</form>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        var STT = 0;
        var selectedItems = [];

        $("#btn-them").click(function() {
            if (!validateInput()) {
                return;
            }
            themVao();

            for (var i = 0; i < selectedItems.length; i++) {
                var item = selectedItems[i];
                var existingRow = findExistingRow(item);
                if (existingRow) {
                    // Sản phẩm đã tồn tại, chỉ cập nhật số lượng
                    updateExistingRow(existingRow, item);
                } else {
                    // Sản phẩm chưa tồn tại, thêm mới
                    addNewRow(item);
                }
            }




        });

        $('#tb-ds-product').on('click', '#btn-xoa', function() {
            var tr = $(this).closest('tr');
            tr.remove();
            STT--;

        });

        $("#product").change(function() {
            $(`#error-${this.id}`).text(""); // Xóa thông báo khi người dùng thay đổi lựa chọn
        });


        $('#product').change(function() {
            var spId = $(this).val();
            $.ajax({
                method: 'GET',
                url: "{{ route('discount.get-product-ajax') }}",
                data: {
                    product_id: spId
                },
                success: function(response) {
                    $('#chi-tiet-sp').html(response);
                }
            });
        });

        $('#name').change(function() {
            $('#hd-name').val($(this).val())
        })

        $('#date-start').change(function() {
            $('#hd-date-start').val($(this).val()).hide()
        })

        $('#date-end').change(function() {
            $('#hd-date-end').val($(this).val()).hide()
        })

        $('#percent').change(function() {
            $('#hd-percent').val($(this).val())
        })

        function findExistingRow(item) {
            var existingRow = null;
            $('#tb-ds-product tbody tr').each(function() {
                var spID = $(this).find('input[name="spID[]"]').val();
                var msID = $(this).find('input[name="msID[]"]').val();
                var dlID = $(this).find('input[name="dlID[]"]').val();
                if (spID == item.prdId && msID == item.MauSacId && dlID == item.DungLuongId) {
                    existingRow = $(this);
                    return false; // Dừng vòng lặp khi tìm thấy sản phẩm trùng
                }
            });
            return existingRow;
        }

        // function updateExistingRow(existingRow, item) {
        //     var soLuongHienTai = parseInt(existingRow.find('td').eq(4).text());
        //     var soLuongMoi = parseInt(item.soLuong);
        //     var giaBan = parseInt(item.giaBan);
        //     var maxQuantity = parseInt(existingRow.find('input[name="quanlity[]"]').attr('max'));

        //     if (soLuongHienTai + soLuongMoi > maxQuantity) {
        //         alert("Số lượng mua phải bé hơn hoặc bằng số lượng tồn kho.");
        //         return;
        //     }

        //     var newQuantity = soLuongHienTai + soLuongMoi;
        //     var toTalNew = newQuantity * giaBan;

        //     existingRow.find('input[name="quanlity[]"]').val(newQuantity.toString());
        //     existingRow.find('td').eq(4).text(newQuantity.toString());
        //     existingRow.find('input[name="total[]"]').val(toTalNew.toString());
        //     existingRow.find('td').eq(6).text(formatNumber(toTalNew).toString());

        //     if (existingRow.find('td').eq(4).find('input[name="quanlity[]"]').length === 0) {
        //         // Nếu không tồn tại, thêm input vào hàng
        //         existingRow.find('td').eq(4).append(`<input type="hidden" name="quanlity[]" value="${newQuantity}" max="${maxQuantity}"/>`);
        //     }
        //     if (existingRow.find('td').eq(6).find('input[name="total[]"]').length === 0) {
        //         // Nếu không tồn tại, thêm input vào hàng
        //         existingRow.find('td').eq(6).append(`<input type="hidden" name="total[]" value="${toTalNew}"/>`);
        //     }
        // }


        function themVao() {
            selectedItems = []; // Reset mảng trước khi chọn mua
            $('#table-hd-ctsp tbody tr').each(function() {
                var checkBox = $(this).find('#buy-id');
                if (checkBox.is(':checked')) {
                    var productId = $(this).find('#product-id').val();
                    var mauSac = $(this).find('#td-color').text();
                    var dungLuong = $(this).find('#td-capacity').text();
                    var giamGia = $(this).find('#percent-id').val();
                    var soLuong = $(this).find('#quanlity-id').val();
                    var giaBan = $('#price-id', this).val();
                    var MauSacId = $('#color-id', this).val();
                    var DungLuongId = $('#capacity-id', this).val();
                    // var maxQuantity = parseInt($(this).find('#quanlity-id').attr('max'));

                    // // Check if quantity is valid
                    // if (parseInt(soLuong) > maxQuantity) {
                    //     alert("Số lượng mua phải bé hơn hoặc bằng số lượng tồn kho.");
                    //     return;
                    // }

                    selectedItems.push({
                        prdId: productId,
                        mauSac: mauSac,
                        dungLuong: dungLuong,
                        giamGia: giamGia,
                        giaBan: giaBan,
                        MauSacId: MauSacId,
                        DungLuongId: DungLuongId,
                        soLuong: soLuong
                    });
                }
            });
        }

        function validateInput() {
            var isValid = true;
            if ($("#hd-name").val() === null) {
                $("#error-name").text("Vui lòng nhập tên khuyến mãi!");
                isValid = false;
            } else {
                $("#error-name").text("");
            }

            if ($("#hd-date-start").val() === null) {
                $("#error-date-start").text("Vui lòng nhập số điện thoại!");
                isValid = false;
            } else {
                $("#error-date-start").text("");
            }
            if ($("#hd-date-end").val() === null) {
                $("#error-date-end").text("Vui lòng chọn sản phẩm!");
                isValid = false;
            } else {
                $("#error-date-end").text("");
            }

            return isValid;
        }

        function addNewRow(item) {
            var stt = $("#tb-ds-product tbody tr").length + 1;
            STT = stt;
            var idNV = $("#admin").find(":selected").val();
            var idKH = $("#customer").find(":selected").val();
            var soDT = $('#phone').val();
            $('#k-h').val(idKH);
            $('#phone').val(soDT);
            var tenSP = $("#product").find(":selected").text();
            var idSP = $("#product").find(":selected").val();
            var msID = item.MauSacId;
            var dlID = item.DungLuongId;
            var mauSac = item.mauSac;
            var soLuong = item.soLuong;
            var dungLuong = item.dungLuong;
            var giamGia = item.giamGia;
            var giaBan = item.giaBan;
            var thanhTien = giaBan - ((giamGia / 100) * giaBan);

            var row = `<tr>
            <td>${stt}</td>
            <td>${tenSP}<input type="hidden" name="spID[]" value="${idSP}"/></td>
            <td>${mauSac}<input type="hidden" name="msID[]" value="${msID}"/></td>
            <td>${dungLuong}<input type="hidden" name="dlID[]" value="${dlID}"/></td>
            <td>${soLuong}<input type="hidden" name="quanlity[]" value="${soLuong}"/></td>
            <td>${formatNumber(giaBan)}<input type="hidden" name="price[]" value="${giaBan}"/></td>
            <td>${giamGia}<input type="hidden" name="percent[]" value="${giamGia}"/></td>
            <td>${formatNumber(thanhTien)}<input type="hidden" name="total[]" value="${thanhTien}"/></td>
            <td><button type="button" class="btn btn-danger" id="btn-xoa">Xóa</button></td>
          </tr>`;

            $('#tb-ds-product').find('tbody').append(row);
        }

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
@endsection