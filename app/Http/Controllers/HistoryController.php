<?php

namespace App\Http\Controllers;

use App\Http\Resources\MoneyResource;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

abstract class HistoryController extends Controller
{
    /**
     * Build period array from period string.
     *
     * @param  Collection  $dates
     * @return Collection
     */
    protected function computePeriods(Collection $dates) : Collection
    {
        return $dates
            ->combine($dates)
            ->map(function (string $date) : CarbonPeriod {
                $dateParts = explode('-', $date);
                if (count($dateParts) === 1) {
                    return CarbonPeriod::create(
                        Carbon::create($dateParts[0])->startOf('year'),
                        Carbon::create($dateParts[0])->endOf('year'),
                    );
                }
                return CarbonPeriod::create(
                    Carbon::create($dateParts[0], $dateParts[1])->startOf('month'),
                    Carbon::create($dateParts[0], $dateParts[1])->endOf('month'),
                );
            });
    }

    /**
     * Build response from aggregate list.
     *
     * @param  array  $history
     * @return Collection
     */
    protected function formatResponse(array $history) : Collection
    {
        return collect($history)
            ->map(function (Collection $aggregates) : Collection {
                return $aggregates->mapInto(MoneyResource::class);
            });
    }
}
