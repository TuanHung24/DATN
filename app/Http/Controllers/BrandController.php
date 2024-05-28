<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function getList(){
        $listBrand = Brand::all();
        return view('brand.list',compact('listBrand'));
    }

    public function addNew(){
        return view('brand.add-new');
    }
    public function hdAddNew(Request $request){
        try{

            $brand= new Brand();
            $brand->name= $request->name;
            $brand->save();

        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
    } 
}
