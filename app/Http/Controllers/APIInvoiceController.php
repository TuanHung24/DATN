<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Rate;
use Illuminate\Http\Request;
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

        return response()->json([
            "success" => true,
            "message" => "Thanh toán thành công!",
            "orderId" => $inVoice->id,
        ]);
    }

    public function statusInvoice($userId)
    {
        try {


            // Lấy danh sách hóa đơn dựa trên user ID
            $inVoice = Invoice::where("customer_id", $userId)->get();

            if ($inVoice->isEmpty()) {
                return response()->json([
                    "success" => false,
                    "message" => "Không tìm thấy đơn hàng cho người dùng này!",
                ]);
            }

            $statusInvoice = [];

            // Lặp qua danh sách hóa đơn và lấy trạng thái tương ứng
            foreach ($inVoice as $order) {
                $statusInvoice[] = [
                    'orderId' => $order->id, // Đặt lại tên cột tương ứng trong CSDL
                    'status' => $order->status, // Đặt lại tên cột tương ứng trong CSDL
                ];
            }

            return response()->json([
                "success" => true,
                "message" => "Lấy trạng thái thành công!",
                "data" => $statusInvoice,
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
        $inVoice = Invoice::findOrFail($request->orderId);

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
            'content' => 'required|string|',
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
