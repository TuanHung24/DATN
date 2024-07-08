@extends('master')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3>Thống kê hóa đơn theo ngày</h3>
</div>
<div class="form-container">

    <div class="form-group" id="day-month-year-statis-day">

        <select id="day">
            <option value="0" disabled selected>Chọn ngày</option>
        </select>
        <select id="month">
            <option value="0" disabled selected>Chọn tháng</option>
        </select>
        <select id="year">
            <option value="0" disabled selected>Chọn năm</option>
        </select>
        <button id="checkDate">Thống kê</button>
    </div>
</div>
<div class="form-group statistics-day" id="statistics-day">
    <div class="stat-item">
        <span>Doanh thu: <strong id='revenue'>0 VND</strong></span>
    </div>
    <div class="stat-item">
        <span>Lãi: <strong id='interestRate'>0 VND</strong></span>
    </div>
    <div class="stat-item">
        <span>Sản phẩm bán chạy: <strong id='top-product'></strong></span>
    </div>
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
@endsection

@section('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        var pieChart;

        var currentYear = new Date().getFullYear();
        var currentMonth = new Date().getMonth() + 1;
        var currentDay = new Date().getDate();

        for (var month = 1; month <= 12; month++) {
            $('#month').append('<option value="' + month + '">Tháng ' + month + '</option>');
        }

        for (var year = 2023; year <= currentYear; year++) {
            $('#year').append('<option value="' + year + '">Năm ' + year + '</option>');
        }

        function populateDays(maxDays) {
            const daySelect = $('#day');
            daySelect.empty();
            for (let i = 1; i <= maxDays; i++) {
                daySelect.append('<option value="' + i + '">Ngày ' + i + '</option>');
            }
        }

        function drawPieChart(data) {
            var ctx = document.getElementById('pieChart').getContext('2d');
            if (pieChart) {
                pieChart.destroy();
            }
            pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Chờ duyệt', 'Đã duyệt', 'Đang giao', 'Đã giao', 'Đã hủy','Hoàn đơn'],
                    datasets: [{
                        label: 'Trạng thái đơn hàng',
                        data: [
                            data.cho_xu_ly,
                            data.da_duyet,
                            data.dang_giao,
                            data.da_giao,
                            data.da_huy,
                            data.hoan_don
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                             'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 159, 64, 1)'
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

            const statusLabels = ['Chờ duyệt', 'Đã duyệt', 'Đang giao', 'Đã giao', 'Đã hủy', 'Hoàn đơn'];
            const backgroundColors = [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 159, 64, 0.8)'
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
                invoiceList.append($('<div class="error">').text('Không có hóa đơn nào.'));
            }
        }

        function updateDays() {
            const month = parseInt($('#month').val());
            const year = parseInt($('#year').val());

            if (!month || !year) {
                return;
            }

            const daysInMonth = new Date(year, month, 0).getDate();
            populateDays(daysInMonth);
        }

        function setDefaultDate() {
            $('#year').val(currentYear);
            $('#month').val(currentMonth);
            updateDays();
            $('#day').val(currentDay);
        }

        function loadStatistics() {
            const day = $('#day').val();
            const month = $('#month').val();
            const year = $('#year').val();

            $.ajax({
                url: "{{ route('statistical-counts') }}",
                type: 'POST',
                data: {
                    day: day,
                    month: month,
                    year: year,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    var topProductsHtml = '';
                    console.log(data.sellProduct);
                    data.sellProduct.forEach(function(product) {
                        topProductsHtml += '<li>Tên sản phẩm: ' + product.product_name + ' - ' + product.color_name + ' - ' + product.capacity_name + ', Số lượng bán: ' + product.totalpd + '</li>';
                    });
                    $('#top-product').html('<ul>' + topProductsHtml + '</ul>');
                    
                    $('#revenue').text(formatNumber(data.revenue) + " VND");
                    $('#interestRate').text(formatNumber(data.interestRate) + ' VND')
                    drawPieChart(data.statuses);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Có lỗi xảy ra: " + error);
                }
            });
        }

        $('#year, #month').on('change', function() {
            updateDays();
        });

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        setDefaultDate();
        loadStatistics();

        $('#checkDate').click(function() {
            const day = $('#day').val();
            const month = $('#month').val();
            const year = $('#year').val();

            if (!day || !month || !year) {
                alert('Vui lòng nhập đầy đủ ngày, tháng, năm.');
                return;
            }

            loadStatistics();
        });
    });
</script>
@endsection