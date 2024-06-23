<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            box-sizing: border-box;
        }
        body {
            line-height: 1.5;
            font-size: 13px;
            margin: 0;
            padding: 15px;
            background-color: #f8f9fa;
        }
        #hd {
            text-align: center;
            margin-bottom: 15px;
        }
        h4 {
            margin: 5px 0;
        }
        .invoice-details {
            margin-bottom: 15px;
        }
        .bd-example {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f1f1f1;
        }
        .total {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            text-align: right;
        }
        .thank-you {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            font-weight: bold;
           
        }
    </style>
</head>

<body>
    <h2 id="hd">Hóa đơn thanh toán</h2>
    <div class="invoice-details">
        <h4>Tên khách hàng: {{$inVoice->customer->name}}</h4>
        <h4>Mã hóa đơn: HD{{$inVoice->id}}</h4>
        <h4>Ngày tạo: {{$inVoice->date}}</h4>
    </div>
    <div class="bd-example">
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listInvoiceDetail as $invoiceDetail)
                <tr>
                    <td>{{ $invoiceDetail->product->name }}</td>
                    <td>{{ $invoiceDetail->quantity }}</td>
                    <td>{{ $invoiceDetail->price_formatted }} vnd</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <span class="total">Thành tiền: {{ $inVoice->total_formatted }} vnd</span>
    </div>
    <div class="thank-you">
        Xin chân thành cảm ơn quý khách đã tin tưởng và ủng hộ cửa hàng chúng tôi. Chúng tôi luôn sẵn sàng phục vụ quý khách một cách tốt nhất!
    </div>
</body>

</html>
