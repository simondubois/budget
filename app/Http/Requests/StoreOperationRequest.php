<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOperationRequest extends FormRequest
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
            'type' => [
                'required',
                'in:allocation,expense,income,transfer',
            ],
            'from_account_id' => $this->fromAccountIdRules(),
            'to_account_id' => $this->toAccountIdRules(),
            'from_envelope_id' => $this->fromEnvelopeIdRules(),
            'to_envelope_id' => $this->toEnvelopeIdRules(),
            'currency_iso' => [
                'string',
                'required',
                Rule::exists('currencies', 'iso'),
            ],
            'name' => [
                'required_unless:type,allocation',
                'max:255',
            ],
            'amount' => [
                'numeric',
                'required',
                'min:0',
                'max:99999999999.99',
            ],
            'date' => [
                'date',
                'required',
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
        return trans('attributes.operation');
    }

    protected function fromAccountIdRules()
    {
        if ($this->type === 'expense' || $this->type === 'transfer') {
            return [
                'required',
                Rule::exists('accounts', 'id'),
            ];
        }

        return 'in:';
    }

    protected function fromEnvelopeIdRules()
    {
        if ($this->type === 'expense') {
            return [
                'required',
                Rule::exists('envelopes', 'id'),
            ];
        }

        return 'in:';
    }

    protected function toAccountIdRules()
    {
        if ($this->type === 'income' || $this->type === 'transfer') {
            return [
                'required',
                Rule::exists('accounts', 'id'),
            ];
        }

        return 'in:';
    }

    protected function toEnvelopeIdRules()
    {
        if ($this->type === 'allocation') {
            return [
                'required',
                Rule::exists('envelopes', 'id'),
            ];
        }

        if ($this->type === 'income') {
            return [
                'nullable',
                Rule::exists('envelopes', 'id'),
            ];
        }

        return 'in:';
    }
}
