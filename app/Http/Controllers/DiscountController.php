<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\DiscountDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function getList(){
        $listDiscount = Discount::paginate(8);
        return view('discount.list', compact('listDiscount'));
    }
    public function addNew(){
        $listProduct = Product::all();
        return view('discount.add-new',compact('listProduct'));
    } 
    public function hdAddNew(Request $request){
        $disCount = new Discount();
        $disCount->name = $request->discount_name;
        $disCount->date_start = $request->date_start;
        $disCount->date_end = $request->date_end;
        $disCount->percent = $request->percent_all;
        $disCount->save();
        for($i=0;$i<count($request->spID);$i++){

            $productDetail = ProductDetail::where('product_id', $request->spID[$i])
                ->where('color_id', $request->msID[$i])
                ->where('capacity_id', $request->dlID[$i])
                ->first();
            
            if($productDetail){

                $disCountDetail = new DiscountDetail();
                $disCountDetail->discount_id = $disCount->id;
                $disCountDetail->product_id = $request->spID[$i];
                $disCountDetail->product_detail_id = $productDetail->id;
                $disCountDetail->percent = $request->percent[$i];
                $disCountDetail->price = $request->total[$i];
                $disCountDetail->save();
            }
            
        }
        return redirect()->route('discount.list');
    } 
    public function upDate($id){
        $disCount = Discount::with('discount_detail')->find($id);
        $listProduct = Product::all();
        return view('discount.update',compact('listProduct', 'disCount'));
    } 
    public function hdUpdate(Request $request, $id){
        $disCount = Discount::find($id);
        $disCount->name = $request->discount_name;
        $disCount->date_start = $request->date_start;
        $disCount->date_end = $request->date_end;
        $disCount->percent = $request->percent_all;
        $disCount->save();
        for($i=0;$i<count($request->spID);$i++){

            $productDetail = ProductDetail::where('product_id', $request->spID[$i])
                ->where('color_id', $request->msID[$i])
                ->where('capacity_id', $request->dlID[$i])
                ->first();
            
            if($productDetail){

                $disCountDetail = new DiscountDetail();
                $disCountDetail->discount_id = $disCount->id;
                $disCountDetail->product_id = $request->spID[$i];
                $disCountDetail->product_detail_id = $productDetail->id;
                $disCountDetail->percent = $request->percent[$i];
                $disCountDetail->price = $request->total[$i];
                $disCountDetail->save();
            }
            
        }
        return redirect()->route('discount.list');
    } 
    public function getProduct(Request $request)
    {
        $productDetail = ProductDetail::where('product_id', $request->product_id)->where('quanlity','>',0)->get();
        return view('discount.get-product-ajax', compact('productDetail'));
    }
    public function getDetail($id){
        $listDiscountDetail = DiscountDetail::where('discount_id',$id)->get();
        if($listDiscountDetail){
            return view('discount.detail',compact('listDiscountDetail'));
        }
        return redirect()->route('discount.list');
    }
}
