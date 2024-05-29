<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use Exception;
use Illuminate\Http\Request;
use SebastianBergmann\Exporter\Exporter;

class InvoiceController extends Controller
{
    public function addNew()
    {
        $listProduct=Product::whereHas('product_detail',function($query){
                $query->where('quanlity','>',0);
        })->with('product_detail')->get();
        
        $listProduct->each(function ($product) {
            $product->product_detail = $product->product_detail->unique('product_id');
        });
        $listCustomer=Customer::all();
        
        return view("invoice.add-new",compact('listProduct','listCustomer'));
 
    }

    public function hdAddnew(Request $request)
    {
        try
        {
       
        $inVoice= new Invoice();
        $inVoice->customer_id= $request->kh;
        $inVoice->phone= $request->phone;
        $inVoice->save();
        $toTal=0;
        
        for($i=0;$i<count($request->spID);$i++)
        {
           $invoiceDetail =new InvoiceDetail();
           $invoiceDetail->customer_id=$inVoice->id;
           $invoiceDetail->product_id=$request->spID[$i];
           $invoiceDetail->color_id=$request->msID[$i];
           $invoiceDetail->capacity_id=$request->dlID[$i];
           $invoiceDetail->quanlity=$request->soLuong[$i];
 
           $productDetail = ProductDetail::where('product_id', $request->spID[$i])
            ->where('color_id', $request->msID[$i])
            ->where('capacity_id', $request->dlID[$i])
            ->first();
            if(!empty($productDetail))
            {
                
                $productDetail->quanlity-=$invoiceDetail->quanlity;
                $productDetail->save();
            }
            
            
           $invoiceDetail->price=$request->giaBan[$i];
           $invoiceDetail->into_money=$request->thanhTien[$i];
           $invoiceDetail->save();
           
           $toTal += $invoiceDetail->into_money;
        }
        $inVoice->total=$toTal;
        $inVoice->status=Invoice::TRANG_THAI_HOAN_THANH;
        $inVoice->save();
        return redirect()->route('invoice.list')->with(['thong_bao'=>"Nhập hóa đơn thành công!"]);
        }catch(Exception $e)
        {
            return back()->withInput()->with(['error:'=>"Error:".$e->getMessage()]);
        }
    } 
    public function getList()
    { 
        $listInvoice = Invoice::orderBy('status','asc')
                   ->orderBy('date', 'desc')
                   ->paginate(10);
        return view("invoice.list", compact('listInvoice'));
    }
    public function getProduct(Request $request)
    {
        $listProductDetail = ProductDetail::where('product_id',$request->productId)->get();
        return view('invoice.get-product',compact('listProductDetail'));
    }
}
