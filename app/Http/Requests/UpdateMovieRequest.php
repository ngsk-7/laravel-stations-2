<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
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
            'title' => ['required', Rule::unique('movies')->ignore($this->id)],
            'image_url' => ['required', 'url'],
            'published_year' => ['required', 'gte:1900'],
            'is_showing' => ['required', 'boolean'],
            'description' => ['required'],
            'genre' => ['required'],
        ];
    }
    //validationでエラーがあった時のエラーメッセージを以下で生成する。
    public function messages()
    {
        return [
            'title.required' => '映画タイトルを入力してください。', 
            'image_url.required' => '画像URLを入力してください。', 
            'image_url.url' => '画像URLはURL形式で入力してください。', 
            'published_year.required' => '公開年を入力してください。', 
            'published_year.gte' => '公開年は1900以上の値を入力してください。', 
            'description.required' => '概要を入力してください。', 
            'genre.required' => 'ジャンルを入力してください。', 
        ];
    }


}
