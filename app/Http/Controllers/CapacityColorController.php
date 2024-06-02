<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Capacity;
use Exception;

class CapacityColorController extends Controller
{
    public function getList(){
        $listColors = Color::all();
        $listCapacity= Capacity::all();
        return view('capacity_color.list',compact('listColors','listCapacity'));
    }

    public function addNewCapacity(){
        return view('capacity_color.add-new-capacity');
    }
    public function addNewColor(){
        return view('capacity_color.add-new-color');
    }
    public function hdAddNewCapacity(Request $request){
        try{

            $capacity= new Capacity();
            $capacity->name= $request->name;
            $capacity->save();
            return redirect()->route('capacity_color.list');

        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
    }
    public function hdAddNewColor(Request $request){
        try{

            $color= new Color();
            $color->name= $request->name;
            $color->save();
            return redirect()->route('capacity_color.list');

        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
    }
}
