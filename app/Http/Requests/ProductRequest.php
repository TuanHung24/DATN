<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $id=$this->route('id');
        return [ 
            'name' => 'required|min:6|max:50|regex:/^[a-zA-Z][a-zA-Z0-9\s]*$/u|unique:products,name,' . $id,

            // 'resolution'=>'required|min:3|max:30',

            'weight'=>'required|numeric|min:100|max:700',

            'description' => 'required|min:3|regex:/^[^!@#$%^&*()_+{}\[\]:;<>?~\\/-]+$/u',

            'size'=>'required|min:10|max:50|regex:/^[^!@#$%^&*()_+{}\[\]:;<>?~\\/]+$/u',
           
            'screen'=>'required|numeric|min:1|max:50',

            'os' => 'required|min:3|max:50|regex:/^[^0-9,^!@#$%^&*()_+{}\[\]:;<>?~\\/\\-][^!@#$%^&*()_+{}\[\]:;<>?~\\/\\-]+$/u',

            'ram'=>'required|numeric|min:1|max:16',

            'camera'=>'required|min:3|max:50',

            'battery'=>'required|numeric|min:1000|max:6000',

            

        ];
    }
    public function messages()
    {
        return[
            'name.required'=>"Tên sản phẩm không được bỏ trống!",
            'name.min'=>"Tên sản phẩm phải lớn hơn :min ký tự!",
            'name.max'=>"Tên sản phẩm phải nhỏ hơn :max ký tự!",
            'name.unique'=>"Tên sản phẩm không được trùng",
            'name.regex'=>"Tên sản phẩm không được bắt đầu bằng ký tự là số và không chứa ký tự đặc biệt!",

           
            
            'weight.required'=>"Trọng lượng không được bỏ trống!",
            'weight.min'=>"Trọng lượng phải lớn hơn :min g!",
            'weight.max'=>"Trọng lượng phải nhỏ hơn :max g!",
            
            'description.required'=>"Mô tả không được bỏ trống!",
            'description.min'=>"Mô tả phải lớn hơn :min ký tự!",
            'description.regex'=>"Mô tả không chứa ký tự đặc biệt!",

            'size.required'=>"Kích thước không được bỏ trống!",
            'size.min'=>"Kích thước từ :min đến :max ký tự!",
            'size.max'=>"Kích thước từ :min đến :max ký tự!",
            'size.regex'=>"Kích thước không chứa ký tự đặc biệt!",

            'screen.required'=>"Màn hình không được bỏ trống!",
            'screen.min'=>"Màn hình phải lớn hơn :min inch!",
            'screen.max'=>"Màn hình phải nhỏ hơn :max inch!",
            
            'os.required'=>"Hệ điều hành không được bỏ trống!",
            'os.min'=>"Hệ điều hành phải lớn hơn :min ký tự!",
            'os.max'=>"Hệ điều hành phải nhỏ hơn :max ký tự!",
            'os.regex'=>"Hệ điều hành không bắt đầu bằng số và không chứa ký tự đặc biệt!",

            'ram.required'=>"Ram không được bỏ trống!",
            'ram.min'=>"Ram phải lớn hơn :minGB!", 
            'ram.max'=>"Ram phải nhỏ hơn :maxGB!", 

            'camera.required'=>"Camera không được bỏ trống!",
            'camera.min'=>"Camera phải lớn hơn :min ký tự!",
            'camera.max'=>"Camera phải nhỏ hơn :max ký tự!",

            'battery.required'=>"battery không được bỏ trống!",
            'battery.min'=>"battery phải lớn hơn :min mAh!", 
            'battery.max'=>"battery phải nhỏ hơn :max mAh!",


        ];
        
    }
}
