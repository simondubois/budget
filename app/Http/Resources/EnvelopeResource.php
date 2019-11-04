<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EnvelopeResource extends JsonResource
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
            'icon' => $this->icon,
            'default_allocation_amount' => $this->default_allocation_amount,
            'default_allocation_currency' => new CurrencyResource($this->cached_currency),
            'cumulated_balance' => new MoneyResource(
                $this->compute('balance', Carbon::minValue(), Carbon::today())
            ),
            'monthly_allocations' => new MoneyResource(
                $this->compute('allocations', Carbon::today()->startOfMonth(), Carbon::today())
            ),
            'monthly_balance' => new MoneyResource(
                $this->compute('balance', Carbon::today()->startOfMonth(), Carbon::today())
            ),
            'monthly_expenses' => new MoneyResource(
                $this->compute('expenses', Carbon::today()->startOfMonth(), Carbon::today())
            ),
            'monthly_incomes' => new MoneyResource(
                $this->compute('incomes', Carbon::today()->startOfMonth(), Carbon::today())
            ),
            'previous_cumulated_balance' => new MoneyResource(
                $this->compute('balance', Carbon::minValue(), Carbon::today()->startOfMonth()->subMonth()->endOfMonth())
            ),
        ];
    }
}
