<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'left_icon' => 'required|image|mimes:jpg,png|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'left_icon.image' => 'ファイルは画像形式である必要があります。',
            'left_icon.mimes' => '画像はJPGまたはPNG形式である必要があります。',
            'left_icon.max' => '画像サイズは2MB以下にしてください。',
        ];
    }
}
