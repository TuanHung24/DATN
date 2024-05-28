<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
class ProviderController extends Controller
{
    public function getList(){
        $listProvider = Provider::all();
        return view('provider.list',compact('listProvider'));
    }

    public function addNew(){
        return view('provider.add-new');
    }
    public function hdAddNew(Request $request){
        try{

            $provider= new Provider();
            $provider->name= $request->name;
            $provider->phone= $request->phone;
            $provider->address= $request->address;
            $provider->status= $request->status;
            $provider->save();

        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
    } 
}
