<?php

namespace App\Http\Controllers;

use App\Currency;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CurrencyHistoryController extends HistoryController
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Currency  $toCurrency
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Currency $toCurrency)
    {
        $periods = $this->computePeriods(collect($request->dates));

        return Currency::fromCache()
            ->where('iso', '!==', $toCurrency->iso)
            ->keyBy('iso')
            ->map(function (Currency $fromCurrency) use ($periods, $toCurrency) : Collection {
                return $periods->map(function (CarbonPeriod $period) use ($fromCurrency, $toCurrency) : float {
                    return $fromCurrency->rates()
                        ->where('target_currency_iso', $toCurrency->iso)
                        ->whereBetween('date', [$period->getStartDate(), $period->getEndDate()])
                        ->average('rate') ?? 0;
                });
            });
    }
}
