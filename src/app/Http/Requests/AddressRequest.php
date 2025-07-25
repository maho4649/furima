<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'left_icon' => 'nullable|mimes:jpeg,png',
            'name' => 'required|string|max:255',
            'zipcode' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'], // ハイフンあり8文字（例: 123-4567）
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'left_icon.mimes' => '画像はjpegまたはpng形式である必要があります。',
            'name.required' => 'お名前は必須です。',
            'zipcode.required' => '郵便番号は必須です。',
            'zipcode.regex' => '郵便番号はハイフン付きの形式（例: 123-4567）で入力してください。',
            'address.required' => '住所は必須です。',
        ];
    }
}
