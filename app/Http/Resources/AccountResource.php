<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'name' => $this->name,
            'bank' => $this->bank,
            'currency' => new CurrencyResource($this->cached_currency),
            'cumulated_balance' => new MoneyResource(
                $this->compute('balance', Carbon::minValue(), Carbon::today())
            ),
            'monthly_balance' => new MoneyResource(
                $this->compute('balance', Carbon::today()->startOfMonth(), Carbon::today())
            ),
        ];
    }
}
