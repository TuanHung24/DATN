@extends('master')
@section('content')
<span class="thong_ke">
    <div class="count_container count_sp">
        <span data-feather="box" class="align-text-bottom" id="icon-tk"></span>
        <h5>Số lượng sản phẩm</h5>
        <span>Đang có: {{$quantityProduct}}</span><br />
        <span>Tổng tiền nhập hàng: {{$totalWarehouse}}đ</span>
    </div>
    <div class="count_container count_hd">
        <span data-feather="shopping-bag" class="align-text-bottom" id="icon-tk"></span>
        <h5>Số lượng hóa đơn</h5>
        <span>Hóa đơn đang giao -> thanh toán: {{$inVoice}}</span><br />
        <span>Đã hủy: {{$backInvoice}}</span><br />
        <span>Tổng tiền hóa đơn xuất: {{$totalInvoice}}đ</span>
    </div>
    <div class="count_container count_nd">
        <span data-feather="users" class="align-text-bottom" id="icon-tk"></span>
        <h5>Số lượng người dùng</h5>
        <span>Tổng số: {{$cusTomer}}</span>
    </div>

    <div class="count_container sp_top">
        <span data-feather="shopping-cart" class="align-text-bottom" id="icon-tk"></span>
        <h5>Sản phẩm bán chạy</h5>
        @foreach ($sellProduct as $item)
        <span>{{$item->product->name}} - Số lượng: {{$item->totalpd}}</span><br />
        @endforeach
    </div>
</span><br><br>
<h4>Thống kê theo biểu đồ hóa đơn:</h4>


<div class="option-m-y">
    <div class="doanh_thu">
        <label for="doanh-thu">Doanh thu:</label>
        <span id="doanh-thu"></span>đ
    </div>
    <!-- <div class="lai"> Lãi: <span id='lai'></span>đ</div> -->
    <div class="sp-da-ban">
        <label for="so-luong">Số lượng sản phẩm đã bán:</label>
        <span id="so-luong"></span>
    </div>
    <div class="hd-da-ban">
        <label for="so-luong-hoa-don">Số lượng đơn hàng:</label>
        <span id="so-luong-hoa-don"></span>
    </div>
    <div class="select-box">
        <select id="monthSelect">
            <option value="0" disabled selected>Chọn tháng</option>
            <!-- Thêm các tùy chọn tháng từ 1 đến 12 -->
        </select>
        <select id="yearSelect">
            <option value="0" disabled selected>Chọn năm</option>
            <!-- Thêm các tùy chọn năm, ví dụ: từ 2020 đến 2030 -->
        </select>
    </div>
    <button class="btn btn-info" id="thong-ke">Thống kê</button>
</div>

<canvas id="orderChart"></canvas>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {

        thongKe();

        for (var month = 1; month <= 12; month++) {
            $('#monthSelect').append('<option value="' + month + '">Tháng ' + month + '</option>');
        }

        var currentYear = new Date().getFullYear();
        for (var year = 2023; year <= currentYear; year++) {
            $('#yearSelect').append('<option value="' + year + '">' + year + '</option>');
        }

        $('#thong-ke').click(function() {
            thongKe();
        });

        function thongKe() {
            var selectedMonth = $('#monthSelect').find(':selected').val();
            var selectedYear = $('#yearSelect').find(':selected').val();

            $.ajax({
                url: "{{route('statistical-month')}}", // URL của API Laravel mà bạn đã tạo
                method: 'GET',
                data: {
                    'month': selectedMonth,
                    'year': selectedYear
                },
                success: function(response) {
                    var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate(); // Điều chỉnh đúng số ngày trong tháng
                    var counts = Array(daysInMonth).fill(0);

                    let tongTienHoaDon = 0;
                    let tongSoLuong = 0;
                    let tongHoaDon = 0;
                    var canvasContainer = $("#orderChart").parent();
                    $("#orderChart").remove();
                    canvasContainer.append('<canvas id="orderChart"></canvas>');
                    var ctx = $("#orderChart");

                    for (var i in response) {
                        var date = new Date(response[i].date);
                        var day = date.getDate();
                        counts[day - 1] = response[i].count;
                        tongTienHoaDon += parseFloat(response[i].tongtien);
                        tongSoLuong += parseInt(response[i].soluong);
                        tongHoaDon += parseInt(response[i].count);
                    }

                    let formattedTongTienHoaDon = formatNumber(tongTienHoaDon);
                    $('#doanh-thu').text(formattedTongTienHoaDon);
                    $('#so-luong').text(tongSoLuong);
                    $('#so-luong-hoa-don').text(tongHoaDon);

                    var chartData = {
                        labels: Array.from({
                            length: daysInMonth
                        }, (_, i) => `${i + 1}/${selectedMonth}`),
                        datasets: [{
                            label: 'Số lượng đơn hàng',
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            data: counts
                        }]
                    };

                    var barGraph = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                y: {
                                    stepSize: 10, // Mỗi bước tăng 10 đơn vị
                                    autoSkip: false,
                                    min: 0,
                                    max: 300 // Giới hạn tối đa là 300
                                },
                                x: {
                                    type: 'category',
                                    position: 'bottom',
                                    time: {
                                        unit: 'day',
                                        displayFormats: {
                                            day: 'DD/MM/YYYY'
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Năm ' + selectedYear
                                    }
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 10,
                                    top: 10,
                                    bottom: 20
                                }
                            }
                        }
                    });
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
@endsection