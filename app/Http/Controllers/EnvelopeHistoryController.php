<?php

namespace App\Http\Controllers;

use App\Envelope;
use App\Http\Resources\MoneyResource;
use App\Money;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EnvelopeHistoryController extends HistoryController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $periods = $this->computePeriods(collect($request->dates));

        return $this->formatResponse([
            'allocations' => $periods->map(function (CarbonPeriod $period) : Money {
                return Envelope::computeGlobal('allocations', $period);
            }),
            'cumulated_balance' => $periods->map(function (CarbonPeriod $period) : Money {
                return Envelope::computeGlobal(
                    'balance',
                    CarbonPeriod::create(Carbon::minValue(), $period->getEndDate())
                );
            }),
            'expenses' => $periods->map(function (CarbonPeriod $period) : Money {
                return Envelope::computeGlobal('expenses', $period);
            }),
            'incomes' => $periods->map(function (CarbonPeriod $period) : Money {
                return Envelope::computeGlobal('incomes', $period);
            }),
            'period_balance' => $periods->map(function (CarbonPeriod $period) : Money {
                return Envelope::computeGlobal('balance', $period);
            }),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Envelope  $envelope
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Envelope $envelope)
    {
        $periods = $this->computePeriods(collect($request->dates));

        return $this->formatResponse([
            'allocations' => $periods->map(function (CarbonPeriod $period) use ($envelope) : Money {
                return $envelope->compute('allocations', $period);
            }),
            'cumulated_balance' => $periods->map(function (CarbonPeriod $period) use ($envelope) : Money {
                return $envelope->compute('balance', CarbonPeriod::create(Carbon::minValue(), $period->getEndDate()));
            }),
            'expenses' => $periods->map(function (CarbonPeriod $period) use ($envelope) : Money {
                return $envelope->compute('expenses', $period);
            }),
            'incomes' => $periods->map(function (CarbonPeriod $period) use ($envelope) : Money {
                return $envelope->compute('incomes', $period);
            }),
            'period_balance' => $periods->map(function (CarbonPeriod $period) use ($envelope) : Money {
                return $envelope->compute('balance', $period);
            }),
        ]);
    }
}
