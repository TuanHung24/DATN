@extends('master')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Thống kê theo tháng</h3>
</div>

<div class="option-m-y">
    <div class="doanh_thu">
        <label for="doanh-thu">Doanh thu:</label>
        <span id="doanh-thu">VND</span>
    </div>
    <div class="doanh_thu">
        <label for="interestRate">Lãi:</label>
        <span id="interestRate">VND</span>
    </div>
    <!-- <div class="lai"> Lãi: <span id='lai'></span>đ</div> -->
    <div class="sp-da-ban">
        <label for="so-luong">Số lượng sản phẩm:</label>
        <span id="so-luong"></span>
    </div>
   
    <div class="hd-da-ban">
        <label for="so-luong-hoa-don">Số lượng đơn hàng:</label>
        <span id="so-luong-hoa-don"></span>
    </div>
    <div class="top-product">
        <label for="top-product">Top sản phẩm bán chạy:</label>
        <span id="top-product"></span>
    </div>
    
</div>
<br>
<div class="form-group" id="month-year-statis">
        <select id="monthSelect">
            <option value="0" disabled selected>Chọn tháng</option>
        </select>

        <select id="yearSelect">
            <option value="0" disabled selected>Chọn năm</option>
            <!-- Thêm các tùy chọn năm, ví dụ: từ 2020 đến 2030 -->
        </select>
        <button class="btn btn-info" id="thong-ke">Thống kê</button>
</div>

<div class="chart-container">
    <canvas id="pieChart" width="300" height="400"></canvas>
    <div id="invoiceDetails" class="invoice-details">
        <h3>Chi tiết trạng thái hóa đơn</h3>
        <div id="invoiceList">
            <!-- Thông tin chi tiết sẽ được thêm vào đây -->
        </div>
    </div>


</div>
<canvas id="orderChart"></canvas>
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {

        var currentYear = new Date().getFullYear();
        var currentMonth = new Date().getMonth() + 1;

        for (var month = 1; month <= 12; month++) {
            $('#monthSelect').append('<option value="' + month + '">Tháng ' + month + '</option>');
        }

        
        for (var year = 2023; year <= currentYear; year++) {
            $('#yearSelect').append('<option value="' + year + '">' + year + '</option>');
        }
        $('#yearSelect').val(currentYear);
        $('#monthSelect').val(currentMonth);
        thongKe();
        StatisTr();
        $('#thong-ke').click(function() {
            thongKe();
            StatisTr();
        });

        function thongKe() {
            var selectedMonth = $('#monthSelect').find(':selected').val();
            var selectedYear = $('#yearSelect').find(':selected').val();

            $.ajax({
                url: "{{route('statistical-month-1')}}",
                method: 'GET',
                data: {
                    'month': selectedMonth,
                    'year': selectedYear
                },
                success: function(response) {
                    
                    var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
                    var counts = Array(daysInMonth).fill(0);

                    let tongTienHoaDon = 0;
                    let tongSoLuong = 0;
                    let tongHoaDon = 0; 
                    var canvasContainer = $("#orderChart").parent();
                    $("#orderChart").remove();
                    canvasContainer.append('<canvas id="orderChart"></canvas>');
                    var ctx = $("#orderChart");

                    for (var i in response.data) {
                        var date = new Date(response.data[i].date);
                        var day = date.getDate();
                        counts[day - 1] = response.data[i].count;
                        tongTienHoaDon += parseFloat(response.data[i].tongtien);
                        tongSoLuong += parseInt(response.data[i].soluong);
                        tongHoaDon += parseInt(response.data[i].count);
                    }

                    let formattedTongTienHoaDon = formatNumber(tongTienHoaDon);
                    let formattedInterestRate = formatNumber(response.interestRate);
                    $('#doanh-thu').text(formattedTongTienHoaDon+' VND');
                    $('#so-luong').text(tongSoLuong);
                    $('#so-luong-hoa-don').text(tongHoaDon);
                    $('#interestRate').text(formattedInterestRate+ ' VND');
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
                                    stepSize: 10,
                                    autoSkip: false,
                                    min: 0,
                                    max: 300
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


        var pieChart = null;

        function drawPieChart(data) {
            if (pieChart) {
                pieChart.destroy();
            }

            var ctx = document.getElementById('pieChart').getContext('2d');

            pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Chờ xử lý', 'Đã duyệt', 'Đang giao', 'Đã giao', 'Đã hủy'],
                    datasets: [{
                        label: 'Trạng thái đơn hàng',
                        data: [
                            data.cho_xu_ly,
                            data.da_duyet,
                            data.dang_giao,
                            data.da_giao,
                            data.da_huy
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 99, 132, 0.8)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: 'Biểu đồ trạng thái đơn hàng'
                    }
                }
            });

            updateInvoiceDetails(data);
        }

        function updateInvoiceDetails(data) {
            const invoiceList = $('#invoiceList');
            invoiceList.empty();

            const statusLabels = ['Chờ xử lý', 'Đã duyệt', 'Đang giao', 'Đã giao', 'Đã hủy'];
            const backgroundColors = [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ];

            let hasInvoices = false;
            statusLabels.forEach((label, index) => {
                const count = data[Object.keys(data)[index]];
                if (count > 0) {
                    hasInvoices = true;
                    const div = $('<div>').css({
                        display: 'flex',
                        alignItems: 'center',
                        marginBottom: '5px'
                    });
                    const colorBox = $('<div>').css({
                        width: '40px',
                        height: '20px',
                        backgroundColor: backgroundColors[index],
                        marginRight: '10px'
                    });
                    const text = $('<span>').text(`${label}: ${count}`);
                    div.append(colorBox).append(text);
                    invoiceList.append(div);
                }
            });

            if (!hasInvoices) {
                invoiceList.append($('<div class="error">').text('Không có trạng thái hóa đơn nào.'));
            }
        }


        drawPieChart({
            cho_xu_ly: 10,
            da_duyet: 10,
            dang_giao: 10,
            da_giao: 10,
            da_huy: 10
        });

        function StatisTr() {

            const month = $('#monthSelect').val();
            const year = $('#yearSelect').val();
            $.ajax({
                url: "{{route('statistical-month-tr')}}",
                type: 'POST',
                data: {
                    month: month,
                    year: year,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    var topProductsHtml = '';
                    data.sellProduct.forEach(function(product) {
                        topProductsHtml += '<li>Tên sản phẩm: ' + product.product_name + ' - ' + product.color_name + ' - '+ product.capacity_name +', Số lượng bán: ' + product.totalpd + '</li>';
                    });
                    $('#top-product').html('<ul>' + topProductsHtml + '</ul>');
                    drawPieChart(data.statuses);
                },
                error: function(xhr, status, error) {
                    alert("Có lỗi xảy ra: " + error);
                }
            });

        }

    });
</script>
@endsection