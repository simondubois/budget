<?php

namespace App\Http\Resources;

use App\Envelope;
use Carbon\Carbon;
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
                    Envelope::computeGlobal('balance', Carbon::minValue(), Carbon::today())
                ),
                'monthly_allocations' => new MoneyResource(
                    Envelope::computeGlobal('allocations', Carbon::today()->startOfMonth(), Carbon::today())
                ),
                'monthly_balance' => new MoneyResource(
                    Envelope::computeGlobal('balance', Carbon::today()->startOfMonth(), Carbon::today())
                ),
                'monthly_expenses' => new MoneyResource(
                    Envelope::computeGlobal('expenses', Carbon::today()->startOfMonth(), Carbon::today())
                ),
                'monthly_incomes' => new MoneyResource(
                    Envelope::computeGlobal('incomes', Carbon::today()->startOfMonth(), Carbon::today())
                ),
                'previous_cumulated_balance' => new MoneyResource(
                    Envelope::computeGlobal('balance', Carbon::minValue(), Carbon::today()->startOfMonth()->subMonth()->endOfMonth())
                ),
            ],
        ];
    }
}
