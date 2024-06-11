<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Exception;

class ProviderController extends Controller
{
    public function getList(){
        $listProvider = Provider::paginate(8);
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
            $provider->save();

        return redirect()->route('provider.list');
        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
    } 
    public function upDate($id){
        $proVider= Provider::find($id);
        if(empty($proVider)){
            return redirect()->route('provider.list');
        }
        return view('provider.update', compact('proVider'));
    }
    public function hdUpdate(Request $request, $id){
        try{

            $provider= Provider::find($id);
            $provider->name   = $request->name;
            $provider->phone  = $request->phone;
            $provider->address= $request->address;
            $provider->status = isset($request->status) ? 1 :0;
            $provider->save();

        return redirect()->route('provider.list');
        }catch(Exception $e){
            return back()->with("error: ".$e);
        }
    } 
}
