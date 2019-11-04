<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;

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
            ->mapSpread(function (Currency $currency, string $name) use ($date) : array {
                return [
                    $this->aggregates()->firstOrNew([
                        'currency_iso' => $currency->iso,
                        'name' => $name,
                        'date' => $date->copy()->startOfMonth(),
                    ]),
                    $this->$name()
                        ->where('currency_iso', $currency->iso)
                        ->whereBetween('date', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])
                        ->sum('amount'),
                ];
            })
            ->eachSpread(function (Aggregate $aggregate, float $amount) : void {
                if (round($amount, 2) === 0.00) {
                    $aggregate->delete();
                    return;
                }
                $aggregate->fill(['amount' => $amount])->save();
            });
    }

    /**
     * Calculate the sum of related aggregates for the given period.
     *
     * @param string $name
     * @param Carbon $min
     * @param Carbon $max
     * @return Money
     */
    protected function computeAggregates(string $name, Carbon $min, Carbon $max) : Money
    {
        return Currency::fromCache()
            ->map(function (Currency $currency) use ($name, $min, $max) : Money {
                return new Money(
                    $this->aggregates()
                        ->where('currency_iso', $currency->iso)
                        ->where('name', $name)
                        ->whereBetween('date', [$min, $max])
                        ->sum('amount') ?? 0,
                    $currency,
                    Carbon::today()
                );
            })
            ->pipe(function (Collection $monies) : Money {
                return Money::sum($monies);
            });
    }

    /**
     * Calculate the sum of global aggregates for the given period.
     *
     * @param string $name
     * @param Carbon $min
     * @param Carbon $max
     * @return Money
     */
    protected static function computeGlobalAggregates(string $name, Carbon $min, Carbon $max) : Money
    {
        return Currency::fromCache()
            ->map(function (Currency $currency) use ($name, $min, $max) : Money {
                return new Money(
                    Aggregate::query()
                        ->where('aggregatable_type', __CLASS__)
                        ->where('currency_iso', $currency->iso)
                        ->where('name', $name)
                        ->whereBetween('date', [$min, $max])
                        ->sum('amount') ?? 0,
                    $currency,
                    Carbon::today()
                );
            })
            ->pipe(function (Collection $monies) : Money {
                return Money::sum($monies);
            });
    }
}
