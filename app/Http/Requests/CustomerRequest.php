<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name' => 'required|min:10|max:50|regex:/^[^\d!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]+$/u',

            'email' => [
                'required',
                'min:15',
                'max:50',
                'regex:/^[a-zA-Z0-9._-]+@gmail\.com$/',
                'unique:customer,email,' . $id,
            ],

            //'username'=>'required|min:6|max:32|regex:/^[a-zA-Z][a-zA-Z0-9]*$/u|not_regex:/[\p{P}\p{M}\p{S}\p{C}\p{Z}]/u|not_regex:/[^\p{L}\p{N}]/u|unique:khach_hang,ten_dang_nhap,' . $id,
            
            'password' => $this->isMethod('post') ? 'required|min:6|max:128|unique:customer,password,'.$id : 'nullable|min:6|max:128|unique:customer,password,'.$id,

            'phone' =>'required|regex:/^0\d{9}$/',

            'address' => 'required|min:10|max:128|regex:/^[^!@#$%^&*()_+{}\[\]:;<>?~\\/-]+$/u',
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>"Tên khách hàng không được bỏ trống!",
            'name.min'=>"Tên khách hàng phải lớn hơn :min ký tự",
            'name.max'=>"Tên khách hàng phải nhỏ hơn :max ký tự",
            'name.regex'=>"Tên khách hàng không được chứa ký tự là số!",
            
            'email.required'=>"Email không được bỏ trống!",
            'email.min'=>"Email phải lớn hơn :min ký tự!",
            'email.max'=>"Email phải nhỏ hơn :max ký tự!",
            'email.regex'=>"Không đúng định dạng Email ví dụ:'abc@gmail.com' !",
            'email.unique'=>"Email đã tồn tại!",

           
            'password.required'=>"Mật khẩu không được bỏ trống!",
            'password.min'=>"Mật khẩu phải lớn hơn :min ký tự!",
            'password.max'=>"Mật khẩu phải nhỏ hơn :max ký tự!",

            'phone.required' => 'Số điện thoại không được bỏ trống!',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số!',

            'address.required'=>"Địa chỉ không được bỏ trống!",
            'address.min'=>"Địa chỉ phải lớn hơn :min ký tự!",
            'address.max'=>"Địa chỉ phải nhỏ hơn :max ký tự!",
            'address.regex' => "Địa chỉ không được chứa ký tự đặc biệt!",

    
        ];
    }
}
