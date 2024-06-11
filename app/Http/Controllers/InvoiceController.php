<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Exporter\Exporter;

class InvoiceController extends Controller
{
    public function addNew()
    {
        $listProduct = Product::whereHas('product_detail', function ($query) {
            $query->where('quanlity', '>', 0);
        })->with('product_detail')->get();

        $listProduct->each(function ($product) {
            $product->product_detail = $product->product_detail->unique('product_id');
        });
        $listCustomer = Customer::all();

        return view("invoice.add-new", compact('listProduct', 'listCustomer'));
    }

    public function hdAddnew(Request $request)
    {
        try {

            $inVoice = new Invoice();
            $inVoice->customer_id = $request->customer_id;
            $inVoice->phone = $request->in_phone;
            $inVoice->payment_method = "Thanh toán khi nhận hàng";
            $inVoice->save();
            $toTal = 0;

            for ($i = 0; $i < count($request->spID); $i++) {
                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->invoice_id = $inVoice->id;
                $invoiceDetail->product_id = $request->spID[$i];
                $invoiceDetail->color_id = $request->msID[$i];
                $invoiceDetail->capacity_id = $request->dlID[$i];
                $invoiceDetail->quanlity = $request->quanlity[$i];

                $productDetail = ProductDetail::where('product_id', $request->spID[$i])
                    ->where('color_id', $request->msID[$i])
                    ->where('capacity_id', $request->dlID[$i])
                    ->first();
                if (!empty($productDetail)) {

                    $productDetail->quanlity -= $invoiceDetail->quanlity;
                    $productDetail->save();
                }


                $invoiceDetail->price = $request->price[$i];
                $invoiceDetail->into_money = $request->total[$i];
                $invoiceDetail->save();

                $toTal += $invoiceDetail->into_money;
            }
            $inVoice->total = $toTal;
            $inVoice->status = Invoice::TRANG_THAI_HOAN_THANH;
            $inVoice->save();
            return redirect()->route('invoice.list')->with(['thong_bao' => "Nhập hóa đơn thành công!"]);
        } catch (Exception $e) {
            return back()->withInput()->with(['error:' => "Error:" . $e->getMessage()]);
        }
    }
    public function getList()
    {
        $listInvoice = Invoice::orderBy('status', 'asc')
            ->orderBy('date', 'desc')
            ->paginate(10);
        return view("invoice.list", compact('listInvoice'));
    }
    public function getProduct(Request $request)
    {
        $productDetail = ProductDetail::with(['color', 'capacity', 'discount_detail.discount'])
            ->where('product_id', $request->product_id)
            ->where('quanlity', '>', 0)
            // ->whereHas('discount_detail.discount', function ($query) {
            //     $query->where('date_start', '<=', Carbon::now('Asia/Ho_Chi_Minh'))
            //         ->where('date_end', '>=', Carbon::now('Asia/Ho_Chi_Minh'));
            // })
            ->get();

            // $productsWithoutDiscountOrExpired = ProductDetail::with(['color', 'capacity'])
            // ->where('product_id', $request->product_id)
            // ->where('quanlity', '>', 0)
            // ->whereDoesntHave('discount_detail')
            // ->orWhereHas('discount_detail.discount', function($query) {
            //     $now = Carbon::now('Asia/Ho_Chi_Minh');
            //     $query->where('date_end', '<', $now); // Chiết khấu đã hết hạn
            // })
            // ->get();
            
            // $productDetail = $productsWithValidDiscount->merge($productsWithoutDiscountOrExpired);

        return view('invoice.get-product-ajax', compact('productDetail'));
    }
    public function updateStatusComplete($id)
    {
        $inVoice = Invoice::find($id);

        if (empty($inVoice) || $inVoice->status != 3) {
            return redirect()->route('invoice.list');
        }

        $inVoice->status = Invoice::TRANG_THAI_HOAN_THANH;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function updateStatusDelivering($id)
    {
        $inVoice = Invoice::find($id);

        if (empty($inVoice) || $inVoice->status != 2) {
            return redirect()->route('invoice.list');
        }

        $inVoice->status = Invoice::TRANG_THAI_DANG_GIAO;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function updateStatusApproved($id)
    {
        $inVoice = Invoice::find($id);

        if (empty($inVoice) || $inVoice->status != 1) {
            return redirect()->route('invoice.list');
        }

        $inVoice->status = Invoice::TRANG_THAI_DA_DUYET;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function updateStatusCancel($id)
    {
        $inVoice = Invoice::find($id);

        if (empty($inVoice) || $inVoice->status != 1) {
            return redirect()->route('invoice.list');
        }

        $inVoice->status = Invoice::TRANG_THAI_DA_HUY;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function invoiceDetail($id)
    {
        $listInvoiceDetail = InvoiceDetail::where('invoice_id', $id)->get();
        return view('invoice.detail', compact('listInvoiceDetail'));
    }
}
