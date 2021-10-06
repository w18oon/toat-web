<?php

namespace App\Http\Requests\IE;

use Illuminate\Foundation\Http\FormRequest;

class PolicyStoreRequest extends FormRequest
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
        $rules = ['type'=>'required'];
        if(!$this->unlimit){
            $rules['rate'] = 'required|numeric';
        }
        return $rules;
    }
}
