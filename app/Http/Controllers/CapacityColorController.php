<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Capacity;

use Exception;
use Illuminate\Support\Facades\Validator;

class CapacityColorController extends Controller
{
    public function getListCapacity()
    {

        $listCapacity = Capacity::paginate(5);
        return view('capacity.list', compact('listCapacity'));
    }
    public function getListColor()
    {

        $listColors = Color::paginate(5);
        return view('color.list', compact('listColors'));
    }
    public function deleteColor($id)
    {
        try {
            $coLor = Color::findOrFail($id);
            $coLor->delete();
            return redirect()->route('color.list')->with(['Success' => "Xóa màu {$coLor->name} thành công!"]);
        } catch (Exception $e) {
            return back()->with(['Error' => "Xóa màu {$coLor->name} thất bại!"]);
        }
    }
    public function deleteCapacity($id)
    {
        try {
            $capaCity = Capacity::findOrFail($id);
            $capaCity->delete();
            return redirect()->route('capacity.list')->with(['Success' => "Xóa dung lượng {$capaCity->name} thành công!"]);
        } catch (Exception $e) {
            return back()->with(['Error' => "Xóa dung lượng {$capaCity->name} thất bại!"]);
        }
    }
    public function hdAddNewCapacity(Request $request)
    {
        $rules = [
            'name' => 'required|numeric|min:1|max:500',
        ];


        $messages = [
            'name.required' => 'Tên dung lượng không được bỏ trống.',
            'name.numeric' => 'Tên dung lượng phải là số.',
            'name.min' => 'Tên màu phải có ít nhất :min ký tự.',
            'name.max' => 'Tên màu không quá :max ký tự.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        try {
            $formatName = $request->name .' '.$request->unit;
            $existingCapacity = Capacity::where('name', $formatName)->first();

            if ($existingCapacity) {
                return response()->json(['error' => 'Dung lượng đã tồn tại'], 400);
            }

            
            $capacity = new Capacity();
            $capacity->name = $formatName;
            $capacity->save();

            return response()->json(['success' => 'Thêm mới dung lượng thành công'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi khi thêm mới dung lượng'], 500);
        }
    }
    public function hdAddNewColor(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:3|max:15|regex:/^[^\d]*$/',
        ];


        $messages = [
            'name.required' => 'Tên màu không được bỏ trống.',
            'name.string' => 'Tên màu phải là một chuỗi ký tự.',
            'name.min' => 'Tên màu phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên màu không quá 15 ký tự.',
            'name.regex' => 'Tên màu không được chứa ký tự số.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {

            $existingColor = Color::where('name', $request->name)->first();

            if ($existingColor) {
                return response()->json(['error' => 'Màu sắc đã tồn tại'], 400);
            }


            $color = new Color();
            $color->name = $request->name;
            $color->save();

            return response()->json(['success' => 'Thêm mới màu sắc thành công'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi khi thêm mới màu sắc'], 500);
        }
    }
}
