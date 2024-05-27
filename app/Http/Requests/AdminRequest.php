<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'phone' =>'required|regex:/^0\d{9}$/',
            'email' => [
                'required',
                'min:15',
                'max:50',
                'regex:/^[a-zA-Z0-9._-]+@gmail\.com$/',
                'unique:admin,email,' . $id,
            ],
                     
            'address' => 'required|min:10|max:128|regex:/^[^!@#$%^&*()_+{}\[\]:;<>?~\\/-]+$/u',
      
            'username' => 'required|min:6|max:60|regex:/^[a-zA-Z][a-zA-Z0-9]*$/u|not_regex:/[\p{P}\p{M}\p{S}\p{C}\p{Z}]/u|not_regex:/[^\p{L}\p{N}]/u|unique:admin,username,' . $id,
 
            'password'=> 'required|min:6|max:128',
            'roles' => 'required|in:1,2,3',
            'avatar'=> 'image|mimes:jpg,png,jpeg|max:6048'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "Tên nhân viên không được bỏ trống!",
            'name.min' => "Tên nhân viên phải lớn hơn :min ký tự",
            'name.max' => "Tên nhân viên phải nhỏ hơn :max ký tự",
            'name.regex'=>"Tên nhân viên không được chứa ký tự là số và ký tự đặc biệt!",
            
            'phone.required' => 'Số điện thoại không được bỏ trống!',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số!',

            'roles.required' => 'Chức vụ chưa được chọn!',
            'roles.in' => 'Chức vụ chưa chọn!!',
            
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
            'username.regex'=>"Tên đăng nhập không được bắt đầu bằng số, không chứa khoản trắng, không được có dấu và chứa ký tự đặc biệt! ",
            'username.unique' => "Tên đăng nhập đã tồn tại!",

            'password.required' => "Mật khẩu không được bỏ trống!",
            'password.min' => "Mật khẩu phải lớn hơn :min ký tự!",
            'password.max' => "Mật khẩu phải nhỏ hơn :max ký tự!",

            'avatar.image' => 'File hình ảnh không hợp lệ!',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg!',
            'avatar.max' => 'Hình ảnh không được vượt quá kích thước tối đa 2048KB!',
            
        ];
    }
}
