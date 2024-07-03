<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Exception;

class ProviderController extends Controller
{

    public function search(Request $request)
    {
        try{
        $query = $request->input('query');
        $listProvider = Provider::where('name', 'like', '%' . $query . '%')
                          ->orWhere('phone', 'like', '%' . $query . '%')
                          ->orWhere('address', 'like', '%' . $query . '%')
                          ->paginate(8);
        return view('provider.list', compact('listProvider', 'query'));
        }catch(Exception $e){
            return back()->with(['Error'=>'Không tìm thấy khách hàng']);
        }
    }

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
        $proVider= Provider::findOrFail($id);
        if(empty($proVider)){
            return redirect()->route('provider.list');
        }
        return view('provider.update', compact('proVider'));
    }
    public function hdUpdate(Request $request, $id){
        try{

            $provider= Provider::findOrFail($id);
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
