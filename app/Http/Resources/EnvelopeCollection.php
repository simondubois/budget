<?php

namespace App\Http\Resources;

use App\Envelope;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EnvelopeCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = EnvelopeResource::class;

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
                    Envelope::computeGlobal(
                        'balance',
                        CarbonPeriod::create(Carbon::minValue(), Carbon::today()->endOfMonth())
                    )
                ),
                'monthly_allocations' => new MoneyResource(
                    Envelope::computeGlobal(
                        'allocations',
                        CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                    )
                ),
                'monthly_balance' => new MoneyResource(
                    Envelope::computeGlobal(
                        'balance',
                        CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                    )
                ),
                'monthly_expenses' => new MoneyResource(
                    Envelope::computeGlobal(
                        'expenses',
                        CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                    )
                ),
                'monthly_incomes' => new MoneyResource(
                    Envelope::computeGlobal(
                        'incomes',
                        CarbonPeriod::create(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth())
                    )
                ),
                'previous_cumulated_balance' => new MoneyResource(
                    Envelope::computeGlobal(
                        'balance',
                        CarbonPeriod::create(
                            Carbon::minValue(),
                            Carbon::today()->startOfMonth()->subMonth()->endOfMonth()
                        )
                    )
                ),
            ],
        ];
    }
}
