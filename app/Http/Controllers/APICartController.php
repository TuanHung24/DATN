<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Cart;
use App\Models\Color;
use App\Models\ImgProduct;
use App\Models\ProductDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APICartController extends Controller
{
    public function addCart(Request $request)
    {
        try {


            $productData = $request->input('productData');

            $cartItem = Cart::where('customer_id', $productData['customer_id'])
                ->where('product_id', $productData['product_id'])
                ->where('color_id', $productData['color_id'])
                ->where('capacity_id', $productData['capacity_id'])
                ->first();

            if ($cartItem) {
                $currentQuantity = $cartItem->quantity;

                if ($currentQuantity + $productData['quantity'] > 3) {
                    $cartItem->quantity = 3;
                    $cartItem->save();
                    return response()->json(['message' => 'Số lượng sản phẩm trong giỏ hàng đã đạt tối đa (3)!'], 400);
                }

                $cartItem->quantity += $productData['quantity'];
                $cartItem->save();
            } else {

                $cartItem = new Cart();
                $cartItem->customer_id = $productData['customer_id'];
                $cartItem->product_id = $productData['product_id'];
                $cartItem->color_id = $productData['color_id'];
                $cartItem->capacity_id = $productData['capacity_id'];
                $cartItem->quantity = $productData['quantity'];
                $cartItem->save();
            }

            return response()->json(['message' => 'Đã thêm sản phẩm vào giỏ hàng thành công!']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Lỗi không hợp lệ!']);
        }
    }
   

    public function deleteCart($id)
    {
        try {
        
            $user = Auth::guard('api')->user();
            
            if (!$user) {
                return response()->json(['message' => 'Người dùng chưa được xác thực.'], 401);
            }
    
          
            $cartItem = Cart::where('id', $id)
                           ->where('customer_id', $user->id)
                           ->firstOrFail();
    
           
            $cartItem->delete();
    
            return response()->json(['message' => "Xóa sản phẩm trong giỏ hàng thành công!"], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Lỗi không hợp lệ: ' . $th->getMessage()], 500);
        }
    }
    

    public function updateCart(Request $request)
    {
        $cartData = $request->input('cartData');

        foreach ($cartData as $item) {
            Cart::updateOrCreate(
                [
                    'customer_id' => $item['customer_id'],
                    'product_id' => $item['product_id'],
                    'capacity_id' => $item['capacity_id'],
                    'color_id' => $item['color_id'],
                ],
                [
                    'quantity' => $item['quantity'],

                ]
            );
        }

        return response()->json(['message' => 'Đã lưu giỏ hàng thành công']);
    }

    public function getCart($id)
    {
        $data = [];

        $cartItems = Cart::where('customer_id', $id)->get();

        foreach ($cartItems as $c) {
            $productDetail = ProductDetail::where('product_id', $c->product_id)
                ->where('color_id', $c->color_id)
                ->where('capacity_id', $c->capacity_id)
                ->with(['discount_detail' => function ($query) {
                    $query->isActive();
                }])
                ->first();

            $capacity = Capacity::find($c->capacity_id);
            $color = Color::find($c->color_id);

            $imgProduct = ImgProduct::where('product_id', $c->product_id)
                ->where('color_id', $c->color_id)
                ->select('id', 'img_url')
                ->first();

            if ($productDetail) {
                $price = $productDetail->price;
                $percent = 0;

                if ($productDetail->discount_detail && $productDetail->discount_detail->isNotEmpty()) {
                    $activeDiscountDetail = $productDetail->discount_detail->first();
                    $price = $activeDiscountDetail->price;
                    $percent = $activeDiscountDetail->percent;
                }

                $data[] = [
                    'id'=>$c->id,
                    'product_id' => $c->product_id,
                    'color_id' => $c->color_id,
                    'capacity_id' => $c->capacity_id,
                    'quantity' => $c->quantity,
                    'product_name' => $productDetail->product->name,
                    'capacity' => $capacity ? $capacity->name : null,
                    'color' => $color ? $color->name : null,
                    'img_product' => $imgProduct,
                    'price' => $price,
                    'percent' => $percent
                ];
            }
        }

        return response()->json(['data' => $data], 200);
    }
}
