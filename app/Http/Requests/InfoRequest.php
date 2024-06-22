<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InfoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = Auth::user()->id;
        return [
            'name' => 'required|min:10|max:50|regex:/^[^\d]+$/u',
            'phone' =>'required|regex:/^0\d{9}$/',
            'email' => [
                'required',
                'min:15',
                'max:80',
                'regex:/^[a-zA-Z0-9._-]+@gmail\.com$/',
                'unique:admin,email,' . $id,
            ],
            
            
            'address' => 'required|min:10|max:128|regex:/^[^!@#$%^&*()_+{}\[\]:;<>?~\\/-]+$/u',
            'username' => 'required|min:6|max:60|regex:/^[a-zA-Z][a-zA-Z0-9]*$/|unique:admin,username,' . $id, 
            'avatar'=> 'image|mimes:jpg,png,jpeg|max:4048'
        ];
    }
    public function messages(){ 
        return [
            'name.required' => "Họ tên không được bỏ trống!",
            'name.min' => "Họ tên phải lớn hơn :min ký tự",
            'name.max' => "Họ tên phải nhỏ hơn :max ký tự",
            'name.regex'=>"Họ tên không được chứa ký tự là số!",
            'phone.required' => 'Số điện thoại không được bỏ trống!',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số!',
            
            'email.required' => "Email không được bỏ trống!",
            'email.min' => "Email phải lớn hơn :min ký tự!",
            'email.max' => "Email phải nhỏ hơn :max ký tự!",
            'email.unique' => "Email đã tồn tại!",
            'email.regex'=>"Không đúng định dạng Email ví dụ:'abc@gmail.com' !",

            'address.required' => "Địa chỉ không được bỏ trống!",
            'address.min' => "Địa chỉ phải lớn hơn :min ký tự!",
            'address.max' => "Địa chỉ phải nhỏ hơn :max ký tự!",
            'address.regex' => "Địa chỉ không được chứa ký tự đặc biệt!",
    
            'username.required' => "Tên đăng nhập không được bỏ trống!",
            'username.min' => "Tên đăng nhập phải lớn hơn :min ký tự!",
            'username.max' => "Tên đăng nhập phải nhỏ hơn :max ký tự!",
            'username.regex'=>"Tên đăng nhập không được bắt đầu bằng số và không được có ký tự đặc biệt!",
            'username.unique' => "Tên đăng nhập đã tồn tại!",

            'avatar.image' => 'File hình ảnh không hợp lệ!',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg!',
            'avatar.max' => 'Hình ảnh không được vượt quá kích thước tối đa 2048KB!',
            
            
            
        ];
    }
}
