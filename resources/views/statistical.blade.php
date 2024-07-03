@extends('master')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Thống kê theo năm</h3>

    <div>
        <select id="yearSelect">
            <option value="0" disabled>Chọn năm</option>
            @php
            $currentYear = date('Y');
            for ($year = 2023; $year <= $currentYear; $year++) { echo "<option value='{$year}'" . ($year==$currentYear ? ' selected' : '' ) . ">{$year}</option>" ; } @endphp </select>

                <button class="btn btn-info" id="thong-ke">Thống kê</button>
    </div>
</div>

<span class="thong_ke">
    <div class="count_container count_sp">
        <span data-feather="box" class="align-text-bottom" id="icon-tk"></span>
        <h5>Số lượng sản phẩm</h5>
        <span>Đang có: <strong id="quantityProduct"></strong></span><br />
        <span>Tổng tiền nhập hàng: <strong id="totalWarehouse"></strong></span>
    </div>
    <div class="count_container count_hd">
        <span data-feather="shopping-bag" class="align-text-bottom" id="icon-tk"></span>
        <h5>Số lượng hóa đơn</h5>
        <span>Hóa đơn: <strong id="inVoice"></strong></span><br />
        <span>Đã hủy: <strong id="backInvoice"></strong></span><br />
        <span>Doanh thu: <strong id="totalInvoice"></strong></span><br />
        <span>Lãi: <strong id="interestRate"></strong></span>
    </div>
    <div class="count_container count_nd">
        <span data-feather="users" class="align-text-bottom" id="icon-tk"></span>
        <h5>Số lượng người dùng</h5>
        <span>Tổng số: <strong id="cusTomer"></strong></span>
    </div>

    <div class="count_container sp_top">
        <span data-feather="shopping-cart" class="align-text-bottom" id="icon-tk"></span>
        <h5>Sản phẩm bán chạy</h5>

        <span id="top-product"></span><br />

    </div>
</span><br><br>
<h4>Thống kê theo biểu đồ:</h4>


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
        $('#yearSelect').val(currentYear);


        var orderChart;



        thongKe();

        // Thiết lập sự kiện click cho nút Thống kê
        $('#thong-ke').click(function() {
            thongKe();
            StatisTr();
        });

        function thongKe() {
            var selectedYear = $('#yearSelect').val();

            $.ajax({
                url: "{{ route('statistical-year-1') }}",
                method: 'GET',
                data: {
                    'year': selectedYear,
                },
                success: function(response) {
                    // Xử lý dữ liệu và cập nhật các phần tử HTML
                    let tongTienHoaDon = 0;
                    let tongSoLuong = 0;
                    let tongHoaDon = 0;
                    let monthsData = [];

                    var canvasContainer = $("#orderChart").parent();
                    $("#orderChart").remove();
                    canvasContainer.append('<canvas id="orderChart"></canvas>');
                    var ctx = $("#orderChart");


                    for (var i in response.invoice) {
                        var month = response.invoice[i].month - 1; // JavaScript month is 0-indexed
                        var count = response.invoice[i].count;
                        monthsData.push({
                            month: month,
                            count: count
                        });

                        tongHoaDon += parseInt(response.invoice[i].count);
                    }


                    var topProductsHtml = '';
                    response.sellProduct.forEach(function(product, index) {
                        topProductsHtml += '<li>Top ' + (index + 1) + ': ' + product.product_name + ' - ' + product.color_name + ' - ' + product.capacity_name + ', Số lượng bán: ' + product.totalpd + '</li>';
                    });
                    $('#top-product').html('<ul>' + topProductsHtml + '</ul>');
                    
                    $('#doanh-thu').text(response.totalInvoice);
                    $('#cusTomer').text(response.cusTomer);
                    $('#so-luong-hoa-don').text(tongHoaDon);
                    $('#totalWarehouse').text(response.totalWarehouse + ' VND')
                    $('#inVoice').text(response.inVoice);
                    $('#backInvoice').text(response.backInvoice);
                    $('#totalInvoice').text(response.totalInvoice + ' VND')
                    $('#interestRate').text(response.interestRate + ' VND')
                    $('#quantityProduct').text(response.quantityProduct)
                    // Cập nhật biểu đồ cột
                    
                    updateColumnChart(monthsData);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function updateColumnChart(monthsData) {
            var labels = [];
            var data = [];

            // Initialize data array with 0 for all 12 months
            for (var i = 1; i <= 12; i++) {
                labels.push('Tháng ' + i);
                data.push(0);
            }

            // Fill the data array with actual data from the backend
            monthsData.forEach(function(item) {
                var month = item.month; // Month is already zero-indexed
                data[month] = item.count; // Assign count to corresponding month
            });

            // Destroy the old chart before creating a new one
            if (typeof orderChart !== 'undefined') {
                orderChart.destroy();
            }

            var ctx = document.getElementById('orderChart').getContext('2d');
            orderChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượng đơn hàng',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Số lượng'
                            },
                            stepSize: 10,
                            autoSkip: false,
                            min: 0,
                            max: 100
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Năm ' + $('#yearSelect').val(),
                            }
                        }
                    }
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
        StatisTr()

        function StatisTr() {



            const year = $('#yearSelect').val();



            $.ajax({
                url: "{{route('statistical-year-tr')}}",
                type: 'GET',
                data: {
                    year: year,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {

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