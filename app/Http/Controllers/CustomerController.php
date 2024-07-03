<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        try{
        $query = $request->input('query');
        $listCusTomer = Customer::where('name', 'like', '%' . $query . '%')
                          ->orWhere('email', 'like', '%' . $query . '%')
                          ->orWhere('phone', 'like', '%' . $query . '%')
                          ->orWhere('address', 'like', '%' . $query . '%')
                          ->paginate(6); 
        return view('customer.list', compact('listCusTomer', 'query'));
        }catch(Exception $e){
            return back()->with(['Error'=>'Không tìm thấy khách hàng']);
        }
    }
    public function getList()
    {
        $listCusTomer = Customer::paginate(6);
        return view('customer.list', compact('listCusTomer'));
    }

    public function AddNew()
    {
        return view('customer.add-new');
    }
    public function hdAddNew(CustomerRequest $request)
    {

        try {

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
        } catch (Exception $e) {
            return back()->withInput()->with(['error:' => "Error:" . $e->getMessage()]);
        }
    }

    public function upDate($id)
    {
        $cusTomer = CusTomer::findOrFail($id);
        if (empty($cusTomer)) {
            return redirect()->route('customer.list');
        }
        return view('customer.update', compact('cusTomer'));
    }

    public function hdUpdate(CustomerRequest $request, $id)
    {

        try {


            $cusTomer = CusTomer::findOrFail($id);

            $cusTomer->name = $request->name;
            $cusTomer->email = $request->email;

            $cusTomer->password = Hash::make($request->password);
            $cusTomer->phone = $request->phone;
            $cusTomer->address = $request->address;
            $cusTomer->status = isset($request->status) ? 1 : 0;
            $cusTomer->save();


            return redirect()->route('customer.list')->with(['Success'=>'Cập nhật khách hàng thành công!']);
        } catch (Exception $e) {
            return back()->withInput()->with(['error:' => "Error:" . $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        try {
            $cusTomer = CusTomer::findOrFail($id);
            $cusTomer->delete();
            return redirect()->route('cusTomer.list')->with(['Success'=>"Xóa tài khoản {$cusTomer->name} thành công!"]);
        } catch (Exception $e) {
            return back()->with(['error:' => "Error:" . $e]);
        }
    }
    public function lock($id)
    {
        try {
            $cusTomer = Customer::findOrFail($id);
            $cusTomer->status = 0;
            $cusTomer->save();
            return redirect()->route('customer.list')->with(['Success' => "Khóa tài khoản {$cusTomer->name} thành công!"]);
        } catch (Exception $e) {
            return back()->with(['Error' => 'Không thể khóa tài khoản này']);
        }
    }
    public function unlock($id)
    {
        try {
            $cusTomer = Customer::findOrFail($id);
            $cusTomer->status = 1;
            $cusTomer->save();
            return redirect()->route('customer.list')->with(['Success' => "Mở tài khoản {$cusTomer->name} thành công!"]);
        } catch (Exception $e) {
            return back()->with(['Error' => 'Không thể mở tài khoản này']);
        }
    }
    public function getInvoice($id)
    {
        $listInvoice = Invoice::where('customer_id', $id)->paginate(5);

        if ($listInvoice->isEmpty()) {
            return redirect()->route('invoice.list')->with('error', 'Hóa đơn không tồn tại');
        }

        return view('customer.invoice', compact('listInvoice'));
    }

    public function getInvoiceDetail($customer_id, $id )
    {
        $invoice = Invoice::where('customer_id', $customer_id)
            ->first();

        $invoiceDetails = InvoiceDetail::where('invoice_id', $id)->get();

        if (!$invoiceDetails) {
            return back()->with('Error', 'Hóa đơn không tồn tại');
        }

        return view('customer.invoice_detail', compact('invoice','invoiceDetails'));
    }
}
