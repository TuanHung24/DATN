<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
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
    public function hdAddNew(AdminRequest $request){

        try{
        
            $request->validate([
                'avatar' => 'nullable|image', // Optional avatar field validation
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admin',
                'username' => 'required|string|max:255|unique:admin',
                'password' => 'required|string|min:6',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'roles' => 'required|integer|in:1,2,3',
            ]);
    
        $file = $request->file('avatar');
        $newAdmin = new Admin();

        if(isset($file)){
            $path = $file->store('avt');
           
            $newAdmin->avatar_url = $path;
            
        }
            $newAdmin->name = $request->name;
            $newAdmin->email = $request->email;
            $newAdmin->username = $request->username;
            $newAdmin->password = Hash::make($request->password);
            $newAdmin->phone = $request->phone;
            $newAdmin->address = $request->address;
            $newAdmin->roles = $request->roles; 
            $newAdmin->save();

        
        return redirect()->route('admin.list');

        }catch(Exception $e){
            return back()->withInput()->with(['error:'=>"Error:".$e]);
        }
    }

    public function upDate($id){
        $aDmin = Admin::find($id);
        if(empty($aDmin)){
            return redirect()->route('admin.list');
        }
        return view('admin.update', compact('aDmin'));
    }

    public function hdUpdate(AdminRequest $request, $id){

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
        $aDmin->status = isset($request->status) ? 1 : 0;
        $aDmin->save();

        
        return redirect()->route('admin.list');
        }catch(Exception $e){
            return back()->withInput()->with(['error' => "Error: " . $e->getMessage()]);
        }
    }
    public function delete($id){

        $aDmin=Admin::find($id);
        if(empty($aDmin)){
            return redirect()->route('admin.list')->with(['Empty'=>"$id không tồn tại!"]);
        }
        $aDmin->status=0;
        $aDmin->save();
        return redirect()->route('admin.list');
    }
}
