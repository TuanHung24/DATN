<?php

namespace App\Http\Controllers;

use App\Imports\WareHouseImport;
use App\Models\Capacity;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductSeries;
use App\Models\Provider;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseController extends Controller
{
    public function search(Request $request)
    {
        try{
            $query = $request->input('query');
            $listWarehouse = Warehouse::where('provider.name', 'like', '%' . $query . '%')
                            ->paginate(10);
            return view('warehouse.list', compact('listWarehouse', 'query'));
        }catch(Exception $e){
            return back()->with(['Error'=>'Không tìm thấy khách hàng']);
        }
    }
    public function addNew()
    {
        $listProvider = Provider::all();
        $listProduct  = Product::all();
        $listColor  = Color::all();
        $listCapacity = Capacity::all();
        $listSeries = ProductSeries::all();
        return view("warehouse.add-new", compact('listProvider', 'listProduct', 'listColor', 'listCapacity', 'listSeries'));
    }

    public function hdAddnew(Request $request)
    {
        try {

            $wareHouse = new Warehouse();
            $wareHouse->provider_id = $request->provider_id;
            $wareHouse->save();
            $toTal = 0;
            
            for ($i = 0; $i < count($request->id_detail); $i++) {
                $productDetail = ProductDetail::findOrFail($request->id_detail[$i]);
                if($productDetail)
                {
                    $productDetail->price=$request->out_price[$i];
                    $productDetail->quantity=$request->quantity[$i];
                    $productDetail->save();
                }
                
                $wareHouseDetail = new WarehouseDetail();
                $wareHouseDetail->warehouse_id=$wareHouse->id;
                $wareHouseDetail->product_id=$productDetail->product_id;
                $wareHouseDetail->color_id=$productDetail->color_id;
                $wareHouseDetail->capacity_id=$productDetail->capacity_id;
                $wareHouseDetail->quantity=$request->quantity[$i];
                $wareHouseDetail->in_price=$request->in_price[$i];
                $wareHouseDetail->out_price=$request->out_price[$i];
                $wareHouseDetail->into_money=$request->into_money[$i];
                $wareHouseDetail->save();

                $toTal += $wareHouseDetail->into_money;
            }
            $wareHouse->total = $toTal;
            $wareHouse->save();
            return redirect()->route('warehouse.list')->with(['thong_bao' => "Nhập đơn hàng {$wareHouse->id} thành công!"]);
        } catch (Exception $e) {

            return back();
        }
    }
    public function getList()
    {
        $listWarehouse = Warehouse::orderBy('status', 'asc')
            ->orderBy('date', 'desc')
            ->paginate(10);
        return view("warehouse.list", compact('listWarehouse'));
    }
    public function getProduct(Request $request)
    {
        $listProductDetail = ProductDetail::where('product_id', $request->productId)->get();
        return view('invoice.get-product', compact('listProductDetail'));
    }
    public function warehouseDetail($id)
    {
        $listWareHouseDetail = WarehouseDetail::where('warehouse_id', $id)->get();
        return view('warehouse.detail', compact('listWareHouseDetail'));
    }
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
        
        Excel::import(new WarehouseImport(), $request->file('file'));

        // Lấy danh sách lỗi từ WarehouseImport
        $import = new WarehouseImport();
        $errors = $import->getErrors();

        if (!empty($errors)) {
            return back()->with('Error', 'Import file không thành công!');
        } else {
            return back()->with('Success', 'Import file thành công!');
        }
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function getProductDetailsBySeries($id)
    {
        $products = Product::where('product_series_id', $id)->get();
        $productDetails = ProductDetail::whereIn('product_id', $products->pluck('id'))->get();
    
        $details = $productDetails->map(function ($detail) {
            return [
                'id' => $detail->id,
                'product_name' => $detail->product->name,
                'color_name' => $detail->color->name,
                'capacity_name' => $detail->capacity->name,
            ];
        });
    
        return response()->json([
            'productDetails' => $details,
        ]);
    }
}
