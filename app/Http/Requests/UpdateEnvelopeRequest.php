<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnvelopeRequest extends FormRequest
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
            'name' => [
                'string',
                'required',
                'max:255',
                Rule::unique('envelopes')->ignore($this->route('envelope')->id),
            ],
            'icon' => [
                'string',
                'required',
                'max:255',
            ],
            'default_allocation_amount' => [
                'numeric',
                'required',
                'min:0',
                'max:99999999999.99',
            ],
            'default_allocation_currency_iso' => [
                'string',
                'required',
                Rule::exists('currencies', 'iso'),
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
        return trans('attributes.envelope');
    }
}
