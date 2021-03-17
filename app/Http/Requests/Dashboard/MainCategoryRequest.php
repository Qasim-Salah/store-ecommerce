<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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
            'photo' => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
            'name' => 'required',
//            'type' => 'required|in:1,2',
            'slug' => 'required|unique:categories,slug,' . $this->id
        ];
    }

    public function messages()
    {

        return [
            'required' => 'هذا الحقل مطلوب ',
            'unique' => 'هذا القسم موجود'
        ];
    }
}
