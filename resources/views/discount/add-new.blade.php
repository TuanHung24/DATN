@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>THÊM MỚI KHUYẾN MÃI</h3>
</div>
<div class="row">
    <div class="col-md-4">
        <label for="name" class="form-label">Tên khuyến mãi</label>
        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
    </div>
    <span class="error" id="error-name"></span>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="date-start" class="form-label">Ngày bắt đầu</label>
        <input type="datetime-local" class="form-control" name="date_start" id="date-start" value="{{old('date_start')}}">
        <span class="error" id="error-date-start"></span>
    </div>
    <div class="col-md-6">
        <label for="date-end" class="form-label">Ngày kết thúc</label>
        <input type="datetime-local" class="form-control" name="date_end" id="date-end" value="{{old('date_end')}}">
        <span class="error" id="error-date-end"></span>
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
<label for="product" class="form-label">Chi tiết sản phẩm:</label> <input type="checkbox" id="checkbox-all" hidden /><label hidden>Chọn tất cả</label>
<div id="chi-tiet-sp"></div>
<div class="col-md-2">
    <button type="button" id="btn-them" class="btn btn-success"><span data-feather="plus"></span>Thêm</button>
</div>
<br />
<form method="POST" action="{{route('discount.hd-add-new')}}">
    @csrf
    <div class="table-responsive">
        <table class="table" id="tb-ds-product">
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
    <input type="" id="hd-name" name="discount_name" />
    <input type="datetime-local" id="hd-date-start" name="date_start" />
    <input type="datetime-local" id='hd-date-end' name="date_end" />

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
                // var existingRow = findExistingRow(item);
                // if (existingRow) {
                //     Sản phẩm đã tồn tại, chỉ cập nhật số lượng
                //     updateExistingRow(existingRow, item);
                // } else {
                //     Sản phẩm chưa tồn tại, thêm mới
                addNewRow(item);
                // }
            }




        });

        $('#tb-ds-product').on('click', '#btn-xoa', function() {
            var tr = $(this).closest('tr');
            tr.remove();
            STT--;

        });

        $("#product").change(function() {
            $(`#error-${this.id}`).text("");
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

        $('#name').on('input', function() {
            $('#hd-name').val($(this).val())
        })

        $('#date-start').change(function() {
            $('#hd-date-start').val($(this).val())
        })

        $('#date-end').change(function() {
            $('#hd-date-end').val($(this).val())
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



        function themVao() {
            selectedItems = []; // Reset mảng trước khi chọn mua
            $('#table-hd-ctsp tbody tr').each(function() {
                var checkBox = $(this).find('#buy-id');
                if (checkBox.is(':checked')) {
                    var productId = $(this).find('#product-id').val();
                    var mauSac = $(this).find('#td-color').text();
                    var dungLuong = $(this).find('#td-capacity').text();
                    var giamGia = $(this).find('#percent-id').val();
                    var soLuong = $(this).find('#quantity-id').val();
                    var giaBan = $('#price-id', this).val();
                    var MauSacId = $('#color-id', this).val();
                    var DungLuongId = $('#capacity-id', this).val();

                    if (parseInt(giamGia) <= 0 || isNaN(giamGia)) {
                        alert('Giảm giá phải lớn hơn 0%');
                        return;
                    } else if (parseInt(giamGia) > 80) {
                        alert('Giảm giá không được quá 80%');
                        return;
                    }

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
            var currentTime = new Date();
            
            
            if ($("#hd-name").val().trim() === "") {
                $("#error-name").text("Vui lòng nhập tên khuyến mãi!");
                isValid = false;
            } else {
                $("#error-name").text("");
            }

            // Lấy giá trị ngày bắt đầu và ngày kết thúc
            var startDateVal = $("#hd-date-start").val();
            var endDateVal = $("#hd-date-end").val();

            // Kiểm tra ngày bắt đầu
            if (startDateVal.trim() === "") {
                $("#error-date-start").text("Vui lòng chọn ngày bắt đầu!");
                isValid = false;
            } else {
                var startDate = new Date(startDateVal);
                if (startDate <= currentTime) {
                    $("#error-date-start").text("Ngày bắt đầu phải lớn hơn giờ hiện tại!");
                    isValid = false;
                } else {
                    $("#error-date-start").text("");
                }
            }

            // Kiểm tra ngày kết thúc
            if (endDateVal.trim() === "") {
                $("#error-date-end").text("Vui lòng chọn ngày kết thúc!");
                isValid = false;
            } else {
                var endDate = new Date(endDateVal);
                if (startDateVal.trim() !== "" && endDate <= new Date(startDateVal)) {
                    $("#error-date-end").text("Ngày kết thúc phải lớn hơn ngày bắt đầu!");
                    isValid = false;
                } else {
                    $("#error-date-end").text("");
                }
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
            <td>${soLuong}<input type="hidden" name="quantity[]" value="${soLuong}"/></td>
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