<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class AdminController extends Controller
{
    public function getList(){
        $listAdmin = Admin::all();
        return view('admin.list',compact('listAdmin'));
    }

    public function AddNew(){
        return view('admin.add-new');
    }
    public function hdAddNew(Request $request){

        try{

        $file = $request->file('avatar');

        if(isset($file)){
            $path = $file->store('avt');
            $listAdmin = new Admin();
            $listAdmin->avatar_url = $path;
            $listAdmin->name = $request->name;
            $listAdmin->email = $request->email;
            $listAdmin->username = $request->username;
            $listAdmin->password = Hash::make($request->password);
            $listAdmin->phone = $request->phone;
            $listAdmin->address = $request->address;
            $listAdmin->roles = $request->roles; 
            $listAdmin->save();
        }
       
        return view('admin.list',compact('listAdmin'));
        }catch(Exception $e){
            return back()->with(['error:'=>"Error:".$e]);
        }
    }

    public function upDate($id){
        $aDmin = Admin::find($id);
        if(empty($aDmin)){
            return redirect()->route('admin.list');
        }
        return view('admin.update', compact('aDmin'));
    }

    public function hdUpdate(Request $request, $id){

        try{

        $file = $request->file('avatar');
        $aDmin = Admin::find($id);
        // if(!empty($aDmin)){
        
        // }
        if(isset($file)){
            $path = $file->store('avt');
            $aDmin->avatar_url = $path;
        }
        $aDmin->name = $request->name;
        $aDmin->email = $request->email;
        $aDmin->username = $request->username;
        $aDmin->password = Hash::make($request->password);
        $aDmin->phone = $request->phone;
        $aDmin->address = $request->address;
        $aDmin->roles = $request->roles; 
        $aDmin->save();

        
        return redirect()->route('admin.list');
        }catch(Exception $e){
            return back()->with(['error:'=>"Error:".$e]);
        }
    }
}
