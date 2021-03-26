<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\ProductQty;
use Illuminate\Foundation\Http\FormRequest;

class SliderImagesRequest extends FormRequest
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
            'photo' => 'required',
        ];
    }

    public function messages()
    {

        return [
            'required' => 'هذا الحقل مطلوب ',
        ];
    }


}
