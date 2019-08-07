<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Money
{
    /**
     * Create a new Money instance.
     *
     * @param float $amount
     * @param Currency $fromCurrency
     * @param Carbon $date
     */
    public function __construct(float $amount, Currency $fromCurrency, Carbon $date)
    {
        $this->amounts = Currency::fromCache()
            ->keyBy('iso')
            ->map(function (Currency $toCurrency) use ($amount, $fromCurrency, $date) : float {
                return $amount ? $amount * $this->getRate($fromCurrency, $toCurrency, $date) : $amount;
            });
    }

    /**
     * Calculate the sum of the provided Money instances.
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @param Collection $monies
     * @return Money
     */
    public static function sum(Collection $monies) : Money
    {
        $total = new Money(0, Currency::fromCache()->first(), Carbon::today());

        $total->amounts->transform(function (float $amount, string $currencyIso) use ($monies) {
            return $monies->pluck('amounts')->sum($currencyIso);
        });

        return $total;
    }

    /**
     * Return a new money instance with an amount value opposite to the current one.
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @return Money
     */
    public function opposite() : Money
    {
        $new = new Money(0, Currency::fromCache()->first(), Carbon::today());

        $new->amounts->transform(function (float $amount, string $currencyIso) : float {
            return -$this->amounts->get($currencyIso);
        });

        return $new;
    }

    /**
     * Return the conversion rate between the two given currencies at the given date.
     *
     * @param Currency $fromCurrency
     * @param Currency $toCurrency
     * @param Carbon $date
     * @return float
     */
    protected function getRate(Currency $fromCurrency, Currency $toCurrency, Carbon $date) : float
    {
        if ($fromCurrency->is($toCurrency)) {
            return 1;
        }

        $rate = $fromCurrency->rates()
            ->whereBetween('date', [$date->copy()->subMonth(), $date])
            ->where('target_currency_iso', $toCurrency->iso)
            ->avg('rate');

        return $rate ?: $this->getRate($fromCurrency, $toCurrency, $date->copy()->subDay());
    }
}
