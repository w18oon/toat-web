<?php

namespace App\Http\Requests\IE;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryInfosStoreRequest extends FormRequest
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
            'attribute_name' => 'required',
            'form_type' => 'required',
        ];
        if($this->form_type == 'select'){
            $rules['form_value'] = 'required';
        }

        return $rules;
    }
}
