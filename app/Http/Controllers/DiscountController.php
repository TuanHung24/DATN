<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function getList(){
        $listDiscount = Discount::all();
        return view('discount.list', compact('listDiscount'));
    }
    public function addNew(){
        $listProduct = Product::all();
        return view('discount.add-new',compact('listProduct'));
    } 
    public function hdAddNew(Request $request){
        $disCount = new Discount();
        
    } 
}
