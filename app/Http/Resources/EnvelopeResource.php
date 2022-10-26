<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
                $this->compute('balance', CarbonPeriod::create(Carbon::minValue(), Carbon::today()->endOfMonth()))
            ),
            'monthly_allocations' => new MoneyResource(
                $this->compute(
                    'allocations',
                    CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                )
            ),
            'monthly_balance' => new MoneyResource(
                $this->compute(
                    'balance',
                    CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                )
            ),
            'monthly_expenses' => new MoneyResource(
                $this->compute(
                    'expenses',
                    CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                )
            ),
            'monthly_incomes' => new MoneyResource(
                $this->compute(
                    'incomes',
                    CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                )
            ),
            'previous_cumulated_balance' => new MoneyResource(
                $this->compute(
                    'balance',
                    CarbonPeriod::create(Carbon::minValue(), Carbon::today()->startOfMonth()->subMonth()->endOfMonth())
                )
            ),
        ];
    }
}
