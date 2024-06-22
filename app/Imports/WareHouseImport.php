<?php

namespace App\Imports;

use App\Models\Capacity;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Provider;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Throwable;

class WareHouseImport implements ToCollection
{
    protected $errors = [];

    public function collection(Collection $rows)
    {
        // Lấy nhà cung cấp từ hàng đầu tiên

        $provider = Provider::where('name', $rows[0][1])->first();
        
        if (!$provider) {
            throw new \Exception("Không tìm thấy nhà cung cấp '{$rows[0][1]}'.");
        }

        // Tạo kho mới
        $warehouse = Warehouse::create([
            'provider_id' => $provider->id,
            'date' => now('Asia/Ho_Chi_Minh'), // Hoặc bạn có thể lấy từ Excel nếu có cột date
            'total' => 0, // Tạm thời đặt total là 0
        ]);
        
        foreach ($rows as $index => $row) {
            if ($index == 0 || $index == 1 || $index == 2) continue; // Bỏ qua hàng tiêu đề
            
            try {
                // Tìm sản phẩm dựa trên tên
                $product = Product::where('name', $row[0])->first();
                if (!$product) {
                    throw new \Exception("Không tìm thấy sản phẩm '{$row[0]}'.");
                }
                
                // Tìm màu sắc dựa trên tên
                $color = Color::where('name', $row[1])->first();
                if (!$color) {
                    throw new \Exception("Không tìm thấy màu '{$row[1]}'.");
                }
                
                // Tìm dung lượng dựa trên tên
                $capacity = Capacity::where('name', $row[2])->first();
                if (!$capacity) {
                    throw new \Exception("Không tìm thấy dung lượng '{$row[2]}'.");
                }
                

                    
                
                // Tạo chi tiết kho mới
                $warehouseDetail = new WarehouseDetail([
                    'warehouse_id' => $warehouse->id,
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                    'capacity_id' => $capacity->id,
                    'quantity' => $row[3], // Sửa chính tả từ "quanlity" thành "quantity"
                    'in_price' => $row[4],
                    'out_price' => $row[5],
                ]);
                
                $productDetail = ProductDetail::where('product_id',$product->id)
                ->where('color_id',$color->id)
                ->where('capacity_id',$capacity->id)->first();
                if (!$productDetail) {
                    throw new \Exception("Không tìm thấy chi tiết sản phẩm!");
                }

                
                $productDetail->update(['price'=>$warehouseDetail->out_price]);
                
                $updateQuantity = $productDetail->quantity + $warehouseDetail->quantity;
                
                $productDetail->update(['quantity'=>$updateQuantity]);
                




                $into_money = $row[3] * $row[4];
                $warehouseDetail->into_money = $into_money;
               
               
                $warehouse->warehouse_detail()->save($warehouseDetail);
                
                
                $total = $warehouse->warehouse_detail()->sum('into_money');
                $warehouse->update(['total' => $total]);
        
            } catch (\Exception $e) {
                // Ghi nhận lỗi nếu có
                $this->errors[] = "Hàng " . ($index + 1) . ": " . $e->getMessage(); // +1 để tính từ hàng 1
            }
        }
        
    }

    public function onError(Throwable $e)
    {
        // Xử lý khi có lỗi xảy ra trong quá trình nhập
        $this->errors[] = $e->getMessage();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
