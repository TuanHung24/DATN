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
        $listAdmin = Admin::paginate(5);
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
            
            if($request->roles == 1 && $this->countAdmin($newAdmin->id) == 2){
                return back()->withInput()->with(['Error'=>"Không thể thêm quá 2 quản lý!"]);
            }
            $newAdmin->roles = $request->roles; 
            
            $newAdmin->gender=$request->gender;
            $newAdmin->save();

        
        return redirect()->route('admin.list')->with(['Success'=>"Thêm mới tài khoản {$newAdmin->username} thành công !"]);

        }catch(Exception $e){
            return back()->withInput()->with(['error:'=>"Error:".$e]);
        }
    }

    public function upDate($id){
        $aDmin = Admin::findOrFail($id);
        if(empty($aDmin)){
            return redirect()->route('admin.list')->with(['Error'=>"Tài khoản này không tồn tại!"]);;
        }
        return view('admin.update', compact('aDmin'));
    }

    public function countAdmin($id){
        $countAdmin = Admin::where('roles',1)->where('id','<>',$id)->count();
        return $countAdmin;
    }
    public function hdUpdate(AdminRequest $request, $id){

        try{

        $file = $request->file('avatar');
        $aDmin = Admin::findOrFail($id);
        
        if(isset($file)){
            $path = $file->store('avt');
            $aDmin->avatar_url = $path;
        }
        $aDmin->name = $request->name;
        $aDmin->email = $request->email;
        $aDmin->username = $request->username;
        $aDmin->phone = $request->phone;
        $aDmin->address = $request->address;
        if($request->roles == 1 && $this->countAdmin($aDmin->id) == 2){
            return back()->withInput()->with(['Error'=>"Không thể thêm quá 2 quản lý!"]);
        }
        $aDmin->roles = $request->roles; 
        $aDmin->gender=$request->gender;
        $aDmin->status = isset($request->status) ? 1 : 0;
        $aDmin->save();

        
        return redirect()->route('admin.list')->with(['Success'=>"Cập nhật tài khoản {$aDmin->username} thành công!"]);
        }catch(Exception $e){
            return back()->withInput()->with(['error' => "Error: " . $e->getMessage()]);
        }
    }
    public function delete($id){

        $aDmin=Admin::findOrFail($id);
        if($aDmin->roles==1){
            return redirect()->route('admin.list')->with(['Error'=>"Không thể khóa tài khoản này!"]);
        }
        if(empty($aDmin)){
            return redirect()->route('admin.list')->with(['Error'=>"$id không tồn tại!"]);
        }
        $aDmin->status=0;
        $aDmin->save();
        return redirect()->route('admin.list')->with(['Success'=>"Khóa tài khoản {$aDmin->username} thành công!"]);
    }
}
