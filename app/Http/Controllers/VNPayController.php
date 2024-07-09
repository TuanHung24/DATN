<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PayMent;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    public function index()
    {
        require_once resource_path('views/vnpay_php/config.php');
        $vnp_url = view('vnpay_php.index');
        return response()->json(['vnpUrl' => $vnp_url]);
    }

    public function ipn(Request $request)
    {
        return view('vnpay_php.vnpay_ipn');
    }

    public function pay(Request $request)
    {
        $vnp_url = view('vnpay_php.vnpay_pay');
        return response()->json(['vnpUrl' => $vnp_url]);
    }
    public function refund(Request $request)
    {
        return view('vnpay_php.vnpay_refund');
    }

    public function createPayment(Request $request)
    {
       
        if (empty($request->hd[0])) {
            return response()->json([
                'success' => false,
                'message' => "Thanh toán không thành công!"
            ]);
        }
        for ($i = 0; $i < count($request->cthd); $i++) {
            $productDetail = ProductDetail::where('product_id', $request->cthd[$i]['product_id'])
                ->where('color_id', $request->cthd[$i]['color_id'])
                ->where('capacity_id', $request->cthd[$i]['capacity_id'])->first();

            if (!$productDetail || $request->cthd[$i]['quantity'] > $productDetail->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Sản phẩm không đủ số lượng để đặt hàng!"
                ],422);
            }
        }



        $inVoice = new Invoice();
        $inVoice->customer_id = $request->hd[0]['customer_id'];
        $inVoice->total = $request->hd[0]['total'];
        $inVoice->address = $request->hd[0]['address'];
        $inVoice->phone = $request->hd[0]['phone'];
        $inVoice->payment_method = $request->hd[0]['payment_method'];
        $inVoice->note = $request->hd[0]['note'];
        $inVoice->ship = $request->hd[0]['ship'];
        $inVoice->save();
        for ($i = 0; $i < count($request->cthd); $i++) {
            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $inVoice->id;
            $invoiceDetail->product_id = $request->cthd[$i]['product_id'];
            $invoiceDetail->color_id = $request->cthd[$i]['color_id'];
            $invoiceDetail->capacity_id = $request->cthd[$i]['capacity_id'];
            $invoiceDetail->quantity = $request->cthd[$i]['quantity'];
            $invoiceDetail->price = $request->cthd[$i]['price'];
            $invoiceDetail->into_money = $request->cthd[$i]['into_money'];
            $invoiceDetail->save();
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET'); 
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = route('vnpay.return');
       

       
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = rand(1, 10000); 

        $vnp_Locale = $request->input('language', 'vn'); 
        $vnp_BankCode = $request->input('bankCode', 'NCB'); 
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; 

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $request->hd[0]['total'] * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $inVoice->id,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $inVoice->id,
            "vnp_ExpireDate" => $expire
        );

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

       


       

        
       
        return response()->json(['vnpay_url' => $vnp_Url,"success" => true,
            "message" => "Thanh toán thành công!",
            "orderId" => $inVoice->id,], 200);
    }

    public function return(Request $request)
    {

        $vnp_HashSecret = env('VNP_HASH_SECRET'); 
        $inputData = $request->except('vnp_SecureHashType', 'vnp_SecureHash');

        
        ksort($inputData);
        $hashData = http_build_query($inputData, '', '&');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);                            
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $payMent = new PayMent();
        $payMent->vnp_TxnRef = $request->vnp_TxnRef;
        $payMent->vnp_Amount = $request->vnp_Amount;
        $payMent->vnp_BankCode = $request->vnp_BankCode;
        $payMent->vnp_BankTranNo = $request->vnp_BankTranNo;
        $payMent->vnp_CardType = $request->vnp_CardType;
        $payMent->vnp_OrderInfo = $request->vnp_OrderInfo;
        $payMent->vnp_PayDate = $request->vnp_PayDate;
        $payMent->vnp_ResponseCode = $request->vnp_ResponseCode;
        $payMent->vnp_TmnCode = $request->vnp_TmnCode;
        $payMent->vnp_TransactionNo = $request->vnp_TransactionNo;
        $payMent->vnp_TransactionStatus = $request->vnp_TransactionStatus;
        $payMent->save();
        
        return view('vnpay_php.vnpay_return', ['secureHash' => $secureHash, 'vnp_SecureHash' => $request->get('vnp_SecureHash')]);
    }
}
