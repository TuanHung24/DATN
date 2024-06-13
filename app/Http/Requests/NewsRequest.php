<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title' => 'required|max:255|min:3|regex:/^[^!@#$%^&*()_+{}\[\]:;<>?~\\/-]+$/u',
            'content' => 'required|min:3|',
        ];
    }
    public function messages()
    {
        return[
            'title.required'=>"Tên sản phẩm không được bỏ trống!",
            'title.min'=>"Tên sản phẩm phải lớn hơn :min ký tự!",
            'title.max'=>"Tên sản phẩm phải nhỏ hơn :max ký tự!",
            'title.regex'=>"Tên sản phẩm không được bắt đầu bằng ký tự là số và không chứa ký tự đặc biệt!",

            'content.required'=>"Tên sản phẩm không được bỏ trống!",
            'content.min'=>"Tên sản phẩm phải lớn hơn :min ký tự!",
        ];
    }
}
