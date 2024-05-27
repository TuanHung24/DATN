<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class CustomerController extends Controller
{
    public function getList(){
        $listCusTomer = Customer::all();
        return view('customer.list',compact('listCusTomer'));
    }

    public function AddNew(){
        return view('customer.add-new');
    }
    public function hdAddNew(CustomerRequest $request){

        try{
            
            // $request->validate([
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|string|email|max:255|unique:cusTomer',
            //     'password' => 'required|string|min:6',
            //     'phone' => 'required|string|max:11',
            //     'address' => 'required|string|max:255',
            // ]);
            
            
            $newcusTomer = new CusTomer();
            $newcusTomer->name = $request->name;
            $newcusTomer->email = $request->email;
            $newcusTomer->password = Hash::make($request->password);
            $newcusTomer->phone = $request->phone;
            $newcusTomer->address = $request->address;
            $newcusTomer->save();

        
        return redirect()->route('customer.list');

        }catch(Exception $e){
            return back()->withInput()->with(['error:'=>"Error:".$e->getMessage()]);
        }
    }

    public function upDate($id){
        $cusTomer = CusTomer::find($id);
        if(empty($cusTomer)){
            return redirect()->route('customer.list');
        }
        return view('customer.update', compact('cusTomer'));
    }

    public function hdUpdate(CustomerRequest $request, $id){

        try{

       
        $cusTomer = CusTomer::find($id);
       
        $cusTomer->name = $request->name;
        $cusTomer->email = $request->email;
        
        $cusTomer->password = Hash::make($request->password);
        $cusTomer->phone = $request->phone;
        $cusTomer->address = $request->address;
        $cusTomer->status = isset($request->status) ? 1 : 0;
        $cusTomer->save();

        
        return redirect()->route('customer.list');
        }catch(Exception $e){
            return back()->withInput()->with(['error:'=>"Error:" . $e->getMessage()]);
        }
    }
    public function delete($id){
        try{

        
            
        $cusTomer=CusTomer::find($id);
        $cusTomer->status=0;
        $cusTomer->save();
        return redirect()->route('cusTomer.list');
        }catch(Exception $e){
            return back()->with(['error:'=>"Error:".$e]);
        }
    }
}
