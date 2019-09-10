<?php

namespace App\Http\Controllers;

use App\Envelope;
use App\Http\Resources\MoneyResource;
use App\Money;
use Carbon\Carbon;
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
        $dates = $this->computeDates(collect($request->dates));

        return $this->formatResponse([
            'allocations' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Envelope::computeGlobal('allocations', $min, $max);
            }),
            'cumulated_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Envelope::computeGlobal('balance', Carbon::minValue(), $max);
            }),
            'expenses' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Envelope::computeGlobal('expenses', $min, $max);
            }),
            'incomes' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Envelope::computeGlobal('incomes', $min, $max);
            }),
            'period_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Envelope::computeGlobal('balance', $min, $max);
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
        $dates = $this->computeDates(collect($request->dates));

        return $this->formatResponse([
            'allocations' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($envelope) : Money {
                return $envelope->compute('allocations', $min, $max);
            }),
            'cumulated_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($envelope) : Money {
                return $envelope->compute('balance', Carbon::minValue(), $max);
            }),
            'expenses' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($envelope) : Money {
                return $envelope->compute('expenses', $min, $max);
            }),
            'incomes' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($envelope) : Money {
                return $envelope->compute('directIncomes', $min, $max);
            }),
            'period_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($envelope) : Money {
                return $envelope->compute('balance', $min, $max);
            }),
        ]);
    }
}
