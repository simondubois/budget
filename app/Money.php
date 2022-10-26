<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Money
{
    /**
     * Create a new Money instance.
     *
     * @param float $amount
     * @param Currency $fromCurrency
     * @param CarbonPeriod $period
     */
    public function __construct(float $amount, Currency $fromCurrency, CarbonPeriod $period)
    {
        $this->amounts = Currency::fromCache()
            ->keyBy('iso')
            ->map(function (Currency $toCurrency) use ($amount, $fromCurrency, $period) : float {
                return $amount ? $amount * $this->getRate($fromCurrency, $toCurrency, $period) : $amount;
            });
    }

    /**
     * Calculate the sum of the provided Money instances.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Collection $monies
     * @return Money
     */
    public static function sum(Collection $monies) : Money
    {
        $total = new Money(
            0,
            Currency::fromCache()->first(),
            CarbonPeriod::create(Carbon::minValue(), Carbon::maxValue())
        );

        $total->amounts->transform(function (float $amount, string $currencyIso) use ($monies) {
            return $monies->pluck('amounts')->sum($currencyIso);
        });

        return $total;
    }

    /**
     * Return a new money instance with an amount value opposite to the current one.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return Money
     */
    public function opposite() : Money
    {
        $new = new Money(
            0,
            Currency::fromCache()->first(),
            CarbonPeriod::create(Carbon::minValue(), Carbon::maxValue())
        );

        $new->amounts->transform(function (float $amount, string $currencyIso) : float {
            return -$this->amounts->get($currencyIso);
        });

        return $new;
    }

    /**
     * Return the conversion rate between the two given currencies for the given period.
     *
     * @param Currency $fromCurrency
     * @param Currency $toCurrency
     * @param CarbonPeriod $period
     * @return float
     */
    protected function getRate(Currency $fromCurrency, Currency $toCurrency, CarbonPeriod $period) : float
    {
        if ($fromCurrency->is($toCurrency)) {
            return 1;
        }

        return Cache::remember(
            "rate-$fromCurrency->iso-$toCurrency->iso-" . $period->getStartDate() . '-' . $period->getEndDate(),
            Carbon::MINUTES_PER_HOUR * Carbon::HOURS_PER_DAY,
            function () use ($fromCurrency, $period, $toCurrency) {
                $rate = $fromCurrency->rates()
                    ->whereBetween('date', [$period->getStartDate(), $period->getEndDate()])
                    ->where('target_currency_iso', $toCurrency->iso)
                    ->avg('rate');

                if ($rate == 0.0) {
                    return $this->getRate(
                        $fromCurrency,
                        $toCurrency,
                        CarbonPeriod::create(
                            $period->getStartDate()->copy()->subMonth()->startOfMonth(),
                            $period->getEndDate()->copy()->subMonth()->endOfMonth()
                        )
                    );
                }

                return $rate;
            }
        );
    }
}
