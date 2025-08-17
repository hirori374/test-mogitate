<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'name' => ['required','string','max:255'],
            'price' => ['required','integer','between:0,10000'],
            'season' => ['required','array'],
            'description' => ['required','string','max:120'],
        ];
    
        if ($this->isMethod('post')) {
            $rules['image'] = ['required','image','mimes:jpeg,jpg,png','max:2048'];
        } else {
            $rules['image'] = ['nullable','mimes:jpeg,jpg,png','max:2048'];
        }
    
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'season.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $price = $this->input('price');

            if (empty($price)) {
                $validator->errors()->add('price', '値段を入力してください');
                $validator->errors()->add('price', '数値で入力してください');
                $validator->errors()->add('price', '0~10000円以内で入力してください');
                return;
            }
            if (!is_numeric($price)) {
                $validator->errors()->add('price', '数値で入力してください');
                $validator->errors()->add('price', '0~10000円以内で入力してください');
            }
            if (($price < 0 || $price > 10000)) {
                $validator->errors()->add('price', '0~10000円以内で入力してください');
            }
        });

        $validator->after(function ($validator) {
            $image = $this->file('image');

            if ($this->isMethod('post') && empty($image)) {
                $validator->errors()->add('image', '商品画像を登録してください');
                $validator->errors()->add('image', '「.png」または「.jpeg」形式でアップロードしてください');
                return;
            }
            if ($this->isMethod('post') && !in_array($image->extension(), ['jpeg', 'jpg', 'png'])) {
                $validator->errors()->add('image', '「.png」または「.jpeg」形式でアップロードしてください');
            }
        });

        $validator->after(function ($validator)
        {
            $description = $this->input('description');

            if (empty($description)) {
                $validator->errors()->add('description', '商品説明を入力してください');
                $validator->errors()->add('description', '120文字以内で入力してください');
                return;
            }
            if ($description > 120) {
                $validator->errors()->add('description', '120文字以内で入力してください');
            }
        });
    }
}
