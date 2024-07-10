<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PayMent;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Rate;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Exporter\Exporter;

class InvoiceController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            $listInvoice = Invoice::where('id', $query)->orWhere('phone', 'like', '%' . $query . '%')
                ->orWhere(function ($queryBuilder) use ($query) {
                    $queryBuilder->whereHas('customer', function ($queryCustomer) use ($query) {
                        $queryCustomer->where('name', 'like', '%' . $query . '%');
                    });
                })
                ->orderBy('status','asc')
                ->orderBy('date','desc')
                ->paginate(10);

            if ($request->ajax()) {
                $view = view('invoice.table', compact('listInvoice'))->render();
                return response()->json(['html' => $view]);
            }

            return view('invoice.list', compact('listInvoice', 'query'));
        } catch (Exception $e) {
            return back()->with(['Error' => 'Không tìm thấy khách hàng']);
        }
    }

    public function addNew()
    {
        $listProduct = Product::whereHas('product_detail', function ($query) {
            $query->where('quantity', '>', 0);
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
                $invoiceDetail->quantity = $request->quantity[$i];

                $productDetail = ProductDetail::where('product_id', $request->spID[$i])
                    ->where('color_id', $request->msID[$i])
                    ->where('capacity_id', $request->dlID[$i])
                    ->first();
                if (!empty($productDetail)) {

                    $productDetail->quantity -= $invoiceDetail->quantity;
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
            ->where('quantity', '>', 0)
            // ->whereHas('discount_detail.discount', function ($query) {
            //     $query->where('date_start', '<=', Carbon::now('Asia/Ho_Chi_Minh'))
            //         ->where('date_end', '>=', Carbon::now('Asia/Ho_Chi_Minh'));
            // })
            ->get();

        // $productsWithoutDiscountOrExpired = ProductDetail::with(['color', 'capacity'])
        // ->where('product_id', $request->product_id)
        // ->where('quantity', '>', 0)
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
        $inVoice = Invoice::findOrFail($id);

        if (empty($inVoice) || $inVoice->status != 3) {
            return redirect()->route('invoice.list');
        }

        $inVoice->status = Invoice::TRANG_THAI_HOAN_THANH;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function updateStatusDelivering($id)
    {
        $inVoice = Invoice::findOrFail($id);

        if (empty($inVoice) || $inVoice->status != 2) {
            return redirect()->route('invoice.list');
        }

        $inVoice->status = Invoice::TRANG_THAI_DANG_GIAO;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function updateStatusApproved($id)
    {
        $inVoice = Invoice::findOrFail($id);

        if (empty($inVoice) || $inVoice->status != 1) {
            return redirect()->route('invoice.list');
        }

        $invoiceDetail = InvoiceDetail::where('invoice_id', $id)->get();

        if (!$invoiceDetail) {
            return redirect()->route('hoa-don.danh-sach')->with('error', "Chi tiết hóa đơn không tồn tại.");
        }


        foreach ($invoiceDetail as $item) {
            $productDetail = ProductDetail::where('product_id', $item->product_id)
                ->where('color_id', $item->color_id)
                ->where('capacity_id', $item->capacity_id)
                ->first();
            if (!$productDetail) {
                return redirect()->route('hoa-don.danh-sach')->with('error', "Chi tiết hóa đơn không tồn tại.");
            }
            $productDetail->quantity -= $item->quantity;
            $productDetail->save();
        }

        $inVoice->status = Invoice::TRANG_THAI_DA_DUYET;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function updateStatusCancel($id)
    {
        $inVoice = Invoice::findOrFail($id);

        if (empty($inVoice) || $inVoice->status != 1) {
            return redirect()->route('invoice.list');
        }

        $inVoice->status = Invoice::TRANG_THAI_DA_HUY;
        $inVoice->save();
        return redirect()->route('invoice.list');
    }

    public function invoiceDetail($id)
    {
        $payMent = PayMent::where('vnp_TxnRef',$id)->first();
        $listInvoiceDetail = InvoiceDetail::where('invoice_id', $id)->get();
        return view('invoice.detail', compact('listInvoiceDetail','payMent'));
    }
}
