<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

$vnp_TmnCode = "R1HI2UX3"; // Mã định danh merchant kết nối (Terminal Id)
$vnp_HashSecret = "G9SFSEMDZNGBLV1OGYFNDYA2MIMLCWG7"; // Secret key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";

$startTime = date("YmdHis");
$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
?>
