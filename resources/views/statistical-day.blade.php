@extends('master')

@section('content')
<div class="form-container">
    <div class="form-group">
        <label for="day">Ngày:</label>
        <select id="day"></select>
    </div>
    <div class="form-group">
        <label for="month">Tháng:</label>
        <select id="month">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
    </div>
    <div class="form-group">
        <label for="year">Năm:</label>
        <select id="year">
            <option value="2023">2023</option>
            <option value="2024">2024</option>
        </select>
    </div>
    <button id="checkDate">Kiểm tra</button>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var pieChart;

        function drawPieChart(data) {
            var ctx = document.getElementById('pieChart').getContext('2d');
            if (pieChart) {
                pieChart.destroy();
            }
            pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Chờ xử lý', 'Đã duyệt', 'Đang giao', 'Hoàn thành', 'Đã hủy'],
                    datasets: [{
                        label: 'Trạng thái đơn hàng',
                        data: [
                            data.cho_xu_ly, 
                            data.da_duyet, 
                            data.dang_giao, 
                            data.hoan_thanh, 
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

            const statusLabels = ['Chờ xử lý', 'Đã duyệt', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
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

        // Vẽ biểu đồ khi tải trang
        drawPieChart({
            cho_xu_ly: 10,
            da_duyet: 10,
            dang_giao: 10,
            hoan_thanh: 10,
            da_huy: 10
        });

        function populateDays(maxDays) {
            const daySelect = $('#day');
            daySelect.empty();
            for (let i = 1; i <= maxDays; i++) {
                daySelect.append(new Option(i, i));
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
            const today = new Date();
            $('#day').val(today.getDate());
            $('#month').val(today.getMonth() + 1); // Tháng bắt đầu từ 0
            $('#year').val(today.getFullYear());
        }

        $('#year, #month').on('change', function() {
            updateDays();
        });

        setDefaultDate();
        updateDays();

        $('#checkDate').click(function() {
            const day = $('#day').val();
            const month = $('#month').val();
            const year = $('#year').val();

            if (!day || !month || !year) {
                alert('Vui lòng nhập đầy đủ ngày, tháng, năm.');
                return;
            }

            $.ajax({
                url: "{{route('statistical-counts')}}",
                type: 'POST',
                data: {
                    day: day,
                    month: month,
                    year: year,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    drawPieChart(data);
                },
                error: function(xhr, status, error) {
                    alert("Có lỗi xảy ra: " + error);
                }
            });
        });
    });
</script>
@endsection
