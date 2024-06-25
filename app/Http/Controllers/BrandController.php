<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;
use App\Models\Brand;
use Exception;

class BrandController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $listBrand = Brand::where('name', 'like', '%' . $query . '%')
            ->paginate(8);
        return view('brand.list', compact('listBrand', 'query'));
    }
    public function getList()
    {
        $listBrand = Brand::paginate(8);
        $listBrandDelete = Brand::onlyTrashed()->get();
        return view('brand.list', compact('listBrand', 'listBrandDelete'));
    }

    public function addNew()
    {
        return view('brand.add-new');
    }
    public function hdAddNew(BrandRequest $request)
    {
        try {
            $file = $request->file('img_url');
            $brand = new Brand();

            if (isset($file)) {
                $path = $file->store('logo_brand');

                $brand->img_url = $path;
            }

            $brand->name = $request->name;
            $brand->save();
            return redirect()->route('brand.list');
        } catch (Exception $e) {
            return back()->withInput()->with("error: " . $e);
        }
    }
    public function upDate($id)
    {
        try {


            $bRand = Brand::find($id);

            return view('brand.update', compact('bRand'));
        } catch (Exception $e) {
            return redirect()->route('brand.list');
        }
    }
    public function hdUpdate(BrandRequest $request, $id)
    {
        try {
            $file = $request->file('img_url');
            $bRand = Brand::find($id);

            if (isset($file)) {
                $path = $file->store('logo_brand');

                $bRand->img_url = $path;
            }

            $bRand->name = $request->name;
            $bRand->save();
            return redirect()->route('brand.list')->with(['success' => "Cập nhật thương hiệu {$bRand->name} thành công!"]);
        } catch (Exception $e) {
            return redirect()->route('brand.list')->with(['Error' => "Lỗi: " . $e]);
        }
    }

    public function delete($id)
    {
        $bRand = Brand::find($id);
        if (empty($bRand)) {
            return "Thương hiệu không tồn tại";
        }

        $bRand->delete();
        return redirect()->route('brand.list')->with(['Success' => "Xóa thương hiệu {$bRand->name} thành công!"]);
    }

    public function restore($id)
    {
        $bRand = Brand::withTrashed()->find($id);
        $bRand->restore();
        return redirect()->route('brand.list')->with(['Success' => "Phục hồi thương hiệu {$bRand->name} thành công "]);
    }

    public function deleted($id)
    {
        $bRand = Brand::withTrashed()->find($id);
        $bRand->forceDelete();
        return redirect()->route('brand.list')->with(['Success' => "Xóa vĩnh viễn thương hiệu {$bRand->name} thành công "]);
    }
}
