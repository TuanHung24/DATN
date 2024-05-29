<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        return [
            'name'=>'required|min:5|max:50|regex:/^[^\d\W_][^\W_]*$/u',
        ];
    }
    public function messages(){
        return[
            'name.required'=>'Tên hãng không được bỏ trống!',
            'name.min'=>'Tên hãng phải lớn hơn :min ký tự!',
            'name.max'=>'Tên hãng phải nhỏ hơn :max ký tự!',
            'name.regex'=>'Tên hãng không được bắt đầu bằng số và không có ký tự đặc biệt!',
        ];
    }
}
