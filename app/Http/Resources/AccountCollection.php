<?php

namespace App\Http\Resources;

use App\Account;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = AccountResource::class;

    /**
     * Transform the resource collection into an array.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'aggregates' => [
                'cumulated_balance' => new MoneyResource(
                    Account::computeGlobal(
                        'balance',
                        CarbonPeriod::create(Carbon::minValue(), Carbon::today()->endOfMonth())
                    )
                ),
                'monthly_balance' => new MoneyResource(
                    Account::computeGlobal(
                        'balance',
                        CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                    )
                ),
            ],
        ];
    }
}
