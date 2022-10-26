<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait MorphManyAggregates
{
    /**
     * Get all of the post's comments.
     */
    public function aggregates()
    {
        return $this->morphMany(Aggregate::class, 'aggregatable');
    }

    /**
     * Update the related aggregates for month for the given date.
     *
     * @return void
     */
    public function updateAggregates(Carbon $date) : void
    {
        Currency::fromCache()
            ->crossJoin($this->aggregateNames)
            ->mapSpread(function (Currency $currency, string $name) use ($date) : Aggregate {
                return $this->aggregates()
                    ->firstOrNew([
                        'currency_iso' => $currency->iso,
                        'name' => $name,
                        'date' => $date->copy()->startOfMonth(),
                    ])
                    ->fill([
                        'amount' => round(
                            $name === 'balance'
                                ? $this->calculateBalanceAggregate($currency, $date)
                                : $this->$name()
                                    ->where('currency_iso', $currency->iso)
                                    ->whereBetween('date', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])
                                    ->sum('amount'),
                            2
                        ),
                    ]);
            })
            ->each(function (Aggregate $aggregate) : void {
                if ($aggregate->amount === 0.00) {
                    $aggregate->delete();
                    return;
                }
                $aggregate->save();
            });

        Cache::store('aggregate')->flush();
    }

    /**
     * Calculate the sum of related aggregates for the given period.
     *
     * @param string $name
     * @param CarbonPeriod $period
     * @return Money
     */
    public function compute(string $name, CarbonPeriod $period) : Money
    {
        return Cache::store('aggregate')->remember(
            __CLASS__ . "-$this->id-$name-" . $period->getStartDate() . '-' . $period->getEndDate(),
            Carbon::MINUTES_PER_HOUR * Carbon::HOURS_PER_DAY,
            function () use ($name, $period) {
                return Money::sum(
                    Currency::fromCache()->flatMap(function (Currency $currency) use ($name, $period) : Collection {
                        return $this->aggregates()
                            ->selectRaw('SUM(amount) AS amount, date, currency_iso')
                            ->where('currency_iso', $currency->iso)
                            ->where('name', $name)
                            ->whereBetween('date', [$period->getStartDate(), $period->getEndDate()])
                            ->groupBy('date', 'currency_iso')
                            ->get()
                            ->pluck('amount_as_money');
                    })
                );
            }
        );
    }

    /**
     * Calculate the sum of global aggregates for the given period.
     *
     * @param string $name
     * @param CarbonPeriod $period
     * @return Money
     */
    public static function computeGlobal(string $name, CarbonPeriod $period) : Money
    {
        return Cache::store('aggregate')->remember(
            __CLASS__ . "-$name-" . $period->getStartDate() . '-' . $period->getEndDate(),
            Carbon::MINUTES_PER_HOUR * Carbon::HOURS_PER_DAY,
            function () use ($name, $period) {
                return Money::sum(
                    Currency::fromCache()->flatMap(function (Currency $currency) use ($name, $period) : Collection {
                        return Aggregate::query()
                            ->where('aggregatable_type', __CLASS__)
                            ->selectRaw('SUM(amount) AS amount, date, currency_iso')
                            ->where('currency_iso', $currency->iso)
                            ->where('name', $name)
                            ->whereBetween('date', [$period->getStartDate(), $period->getEndDate()])
                            ->groupBy('date', 'currency_iso')
                            ->get()
                            ->pluck('amount_as_money');
                    })
                );
            }
        );
    }
}
