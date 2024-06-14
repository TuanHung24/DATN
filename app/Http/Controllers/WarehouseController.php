<?php

namespace App\Http\Controllers;

use App\Imports\WareHouseImport;
use App\Models\Capacity;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Provider;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseController extends Controller
{
    public function addNew()
    {
        $listProvider = Provider::all();
        $listProduct  = Product::all();
        $listColor  = Color::all();
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
                $productDetail->price = $request->out_price[$i];
                $productDetail->quantity += $request->quantity[$i];
                $productDetail->save();
            }
            else{
                $productDetail = new productDetail();
                $productDetail->product_id   = $request->idSP[$i];
                $productDetail->color_id    =$request->color_id[$i];
                $productDetail->capacity_id =$request->capacity_id[$i];
                $productDetail->price       =$request->out_price[$i];
                $productDetail->quantity      =$request->quantity[$i];
                $productDetail->save();
            }
            
            $wareHouseDetail->warehouse_id      = $wareHouse->id;
            $wareHouseDetail->color_id         = $request->color_id[$i];
            $wareHouseDetail->capacity_id      = $request->capacity_id[$i];
            $wareHouseDetail->quantity           = $request->quantity[$i];
            $wareHouseDetail->in_price           = $request->in_price[$i];
            $wareHouseDetail->out_price            = $request->out_price[$i];
            $wareHouseDetail->into_money         = $request->into_money[$i];
            $wareHouseDetail->save();
            
            $toTal += $wareHouseDetail->into_money;

        }
        $wareHouse->total = $toTal;
        $wareHouse->save();
        return redirect()->route('warehouse.list')->with(['thong_bao'=>"Nhập đơn hàng {$wareHouse->id} thành công!"]);
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
    public function warehouseDetail($id){
        $listWareHouseDetail = WarehouseDetail::where('warehouse_id', $id)->get();
        return view('warehouse.detail', compact('listWareHouseDetail'));
    }
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // try {
            // Thực hiện import từ file Excel
            Excel::import(new WarehouseImport(), $request->file('file'));

            // Lấy danh sách lỗi từ WarehouseImport
            $import = new WarehouseImport();
            $errors = $import->getErrors();

            if (!empty($errors)) {
                return back()->with('Error', 'Import file không thành công!');
            } else {
                return back()->with('Success', 'Import file thành công!');
            }
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Import failed: ' . $e->getMessage());
        // }
    }
}
