<?php

namespace App\Http\Controllers;

use App\Currency;
use Carbon\Carbon;
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
        $dates = $this->computeDates(collect($request->dates));

        return Currency::fromCache()
            ->where('iso', '!==', $toCurrency->iso)
            ->keyBy('iso')
            ->map(function (Currency $fromCurrency) use ($dates, $toCurrency) : Collection {
                return $dates->mapSpread(function (Carbon $min, Carbon $max) use ($fromCurrency, $toCurrency) : float {
                    return $fromCurrency->rates()
                        ->where('target_currency_iso', $toCurrency->iso)
                        ->whereBetween('date', [$min, $max])
                        ->average('rate') ?? 0;
                });
            });
    }
}
