<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccountRequest extends FormRequest
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
            'currency_iso' => [
                'string',
                'required',
                Rule::exists('currencies', 'iso'),
            ],
            'name' => [
                'string',
                'required',
                'max:255',
                Rule::unique('accounts'),
            ],
            'bank' => [
                'string',
                'required',
                'max:255',
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('attributes.account');
    }
}
