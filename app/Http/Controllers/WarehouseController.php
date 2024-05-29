<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Colors;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Provider;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Exception;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function addNew()
    {
        $listProvider = Provider::all();
        $listProduct  = Product::all();
        $listColor  = Colors::all();
        $listCapacity = Capacity::all();
        return view("warehouse.add-new",compact('listProvider','listProduct','listColor','listCapacity'));
 
    }

    public function hdAddnew(Request $request)
    {
        try
        {
       
        $wareHouse= new Warehouse();
        $wareHouse->provider_id= $request->provider_id;
        $wareHouse->save();
        $toTal=0;
        
        for($i=0;$i<count($request->idSP);$i++)
        {
            $wareHouseDetail= new WarehouseDetail();
            $wareHouseDetail->warehouse_id         = $wareHouse->id;
            $wareHouseDetail->product_id          = $request->idSP[$i];
            $productDetail=ProductDetail::where('product_id',$request->idSP[$i])->where('color_id',$request->color_id[$i])->where('capacity_id',$request->capacity_id[$i])->get();
            if(count($productDetail)>0){
                $productDetail=ProductDetail::where('product_id',$request->idSP[$i])->where('color_id',$request->color_id[$i])->where('capacity_id',$request->capacity_id[$i])->first();
                $productDetail->price = $request->price[$i];
                $productDetail->quanlity += $request->quanlity[$i];
                $productDetail->save();
            }
            else{
                $productDetail = new productDetail();
                $productDetail->product_id   = $request->idSP[$i];
                $productDetail->color_id    =$request->color_id[$i];
                $productDetail->capacity_id =$request->capacity_id[$i];
                $productDetail->price       =$request->price[$i];
                $productDetail->quanlity      =$request->quanlity[$i];
                $productDetail->save();
            }
            
            $wareHouseDetail->warehouse_id      = $wareHouse->id;
            $wareHouseDetail->color_id         = $request->color_id[$i];
            $wareHouseDetail->capacity_id      = $request->capacity_id[$i];
            $wareHouseDetail->quanlity           = $request->quanlity[$i];
            $wareHouseDetail->in_price           = $request->in_price[$i];
            $wareHouseDetail->out_price            = $request->out_price[$i];
            $wareHouseDetail->into_money         = $request->into_money[$i];
            $wareHouseDetail->save();
            
            $toTal += $wareHouseDetail->into_money;

        }
        $wareHouse->total = $toTal;
        $wareHouse->save();
        return redirect()->route('nhap-hang.danh-sach')->with(['thong_bao'=>"Nhập đơn hàng {$wareHouse->id} thành công!"]);
        }catch(Exception $e)
        {
            
            return back();
        }
    } 
    public function getList()
    { 
        $listWarehouse = Warehouse::orderBy('status','asc')
                   ->orderBy('date', 'desc')
                   ->paginate(10);
        return view("warehouse.list", compact('listWarehouse'));
    }
    public function getProduct(Request $request)
    {
        $listProductDetail = ProductDetail::where('product_id',$request->productId)->get();
        return view('invoice.get-product',compact('listProductDetail'));
    }
}
