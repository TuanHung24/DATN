<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\ProductDetail;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PgSql\Lob;

class APIInvoiceController extends Controller
{
    public function newInvoice(Request $request)
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

            $inVoice = new Invoice();
            $inVoice->customer_id = $request->hd[0]['customer_id'];
            $inVoice->total = $request->hd[0]['total'];
            $inVoice->address = $request->hd[0]['address'];
            $inVoice->phone = $request->hd[0]['phone'];
            $inVoice->payment_method = $request->hd[0]['payment_method'];
            $inVoice->note = $request->hd[0]['note'];
            $inVoice->ship = $request->hd[0]['ship'];
            $inVoice->save();
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

        return response()->json([
            "success" => true,
            "message" => "Thanh toán thành công!",
            "orderId" => $inVoice->id,
        ]);
    }

    public function statusInvoice($userId)
    {
        try {

            $inVoice = Invoice::with(['invoice_detail.product.img_product', 'invoice_detail.color:id,name', 'invoice_detail.capacity:id,name'])
                ->where('customer_id', $userId)
                ->orderBy('status', 'asc')
                ->orderBy('date', 'desc')
                ->get();

            if ($inVoice->isEmpty()) {
                return response()->json([
                    "success" => false,
                    "message" => "Không tìm thấy đơn hàng cho người dùng này!",
                ]);
            }



            return response()->json([
                "success" => true,
                "data" => $inVoice,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Có lỗi khi xử lý yêu cầu: " . $e->getMessage(),
            ]);
        }
    }
    public function statusCancel(Request $request)
    {

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'Người dùng chưa được xác thực.'], 401);
        }

        $inVoice = Invoice::where('customer_id', $user->id)
            ->where('id', $request->orderId)
            ->first();

        if (empty($inVoice)) {
            return response()->json([
                "success" => false,
                "message" => "Hóa đơn không tồn tại!"
            ]);
        }
        if ($inVoice->status != Invoice::TRANG_THAI_CHO_XU_LY) {

            return response()->json([
                "success" => false,
                "message" => "Hóa đơn hủy không thành công!"
            ]);
        }
        $inVoice->status = Invoice::TRANG_THAI_DA_HUY;
        $inVoice->save();

        return response()->json([
            "success" => true,
            "message" => "Hủy hóa đơn thành công!",
            "data" => $inVoice
        ]);
    }

    public function refundOrder(Request $request)
    {

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'Người dùng chưa được xác thực.'], 401);
        }

        $inVoice = Invoice::where('customer_id', $user->id)
            ->where('id', $request->orderId)
            ->first();

        if (empty($inVoice)) {
            return response()->json([
                "success" => false,
                "message" => "Hóa đơn không tồn tại!"
            ]);
        }

        $invoiceDate = Carbon::parse($inVoice->date);
        $currentDate = Carbon::now(new \DateTimeZone('Asia/Ho_Chi_Minh'));
        $difference = $currentDate->diffInDays($invoiceDate);

        if ($difference > 2) {
            return response()->json([
                "success" => false,
                "message" => "Hóa đơn đã quá 2 ngày, không thể hoàn trả!"
            ]);
        }

        if ($inVoice->status != Invoice::TRANG_THAI_HOAN_THANH) {
            return response()->json([
                "success" => false,
                "message" => "Hóa đơn hoàn trả không thành công!"
            ]);
        }
        $inVoice->status = Invoice::TRANG_THAI_HOAN_TRA;
        $inVoice->save();

        return response()->json([
            "success" => true,
            "message" => "Hoàn trả hóa đơn thành công!",
            "data" => $inVoice
        ]);
    }

    public function evaLuate(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'star' => 'required|numeric|between:1,5',
            'color_id' => 'required|numeric',
            'capacity_id' => 'required|numeric',
        ], [
            'customer_id.required' => 'ID khách hàng là bắt buộc.',
            'customer_id.numeric' => 'ID khách hàng phải là một số.',
            'product_id.required' => 'ID sản phẩm là bắt buộc.',
            'product_id.numeric' => 'ID sản phẩm phải là một số.',
            'star.required' => 'Số sao là bắt buộc.',
            'star.numeric' => 'Nội dung bình luận là bắt buộc.',
            'star.between' => 'Số sao phải từ :between',
        ]);

        $raTe = new Rate();
        $raTe->customer_id = $request->customer_id;
        $raTe->product_id = $request->product_id;
        $raTe->capacity_id = $request->capacity_id;
        $raTe->color_id = $request->color_id;
        $raTe->star = $request->star;
        $raTe->save();

        return response()->json([
            'success' => true,
            'message' => "Đánh giá thành công!"
        ]);
    }
    public function comMent(Request $request)
    {

        $request->validate([
            'customer_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'content' => 'required|string|min:5|max:100',
            'color_id' => 'required|numeric',
            'capacity_id' => 'required|numeric',
        ], [
            'customer_id.required' => 'ID khách hàng là bắt buộc.',
            'customer_id.numeric' => 'ID khách hàng phải là một số.',
            'product_id.required' => 'ID sản phẩm là bắt buộc.',
            'product_id.numeric' => 'ID sản phẩm phải là một số.',
            'content.required' => 'Nội dung bình luận là bắt buộc.',
            'content.string' => 'Nội dung bình luận phải là một chuỗi ký tự.',
        ]);
        $inVoice = Invoice::where('id',$request->invoice_id)->where('customer_id',$request->customer_id)
        ->where('status',4)->first();
        if($inVoice){
            return response()->json([
                'success' => false,
                'message' => "Đơn hàng không tồn tại!"
            ]);
        }
        
        $comMent = new Comment();
        $comMent->customer_id = $request->customer_id;
        $comMent->product_id = $request->product_id;
        $comMent->capacity_id = $request->capacity_id;
        $comMent->color_id = $request->color_id;
        $comMent->content = $request->content;
        $comMent->save();
        return response()->json([
            'success' => true,
            'message' => "Bình luận thành công!"
        ]);
    }
}
