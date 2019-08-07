<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from_account_id' => $this->from_account_id,
            'to_account_id' => $this->to_account_id,
            'from_envelope_id' => $this->from_envelope_id,
            'to_envelope_id' => $this->to_envelope_id,
            'name' => $this->name,
            'amount' => new MoneyResource($this->amount),
            'date' => $this->date->toDateString(),
            'type' => $this->type_name,
            'currency' => new CurrencyResource($this->cached_currency),
        ];
    }
}
