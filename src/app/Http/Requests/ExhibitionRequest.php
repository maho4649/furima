<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,png'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer'],
            'condition' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',
            'description.required' => '商品説明は必須です。',
            'description.max' => '商品説明は255文字以内で入力してください。',
            'image.required' => '商品画像は必須です。',
            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => '画像はjpgまたはpng形式である必要があります。',
            'categories.required' => 'カテゴリーは1つ以上選択してください。',
            'condition.required' => '商品の状態は必須です。',
            'price.required' => '商品価格は必須です。',
            'price.numeric' => '価格は数値で入力してください。',
            'price.min' => '価格は0円以上で入力してください。',
        ];
    }
}
