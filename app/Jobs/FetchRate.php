<?php

namespace App\Jobs;

use App\Currency;
use App\Rate;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FetchRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Base currency
     *
     * @var Currency
     */
    protected $baseCurrency;

    /**
     * Date
     *
     * @var Carbon
     */
    protected $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Currency $baseCurrency, Carbon $date)
    {
        $this->baseCurrency = $baseCurrency;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->downloadRates()->each(function (float $rate, string $targetCurrencyIso) {
            $this->baseCurrency->rates()->firstOrCreate(
                ['target_currency_iso' => $targetCurrencyIso, 'date' => $this->date],
                ['rate' => $rate]
            );
        });
    }

    /**
     * Download the rates from external service.
     *
     * @return Collection
     */
    protected function downloadRates() : Collection
    {
        $url = 'https://api.exchangerate.host/' . $this->date->toDateString()
            . '?base=' . $this->baseCurrency->iso
            . '&symbols=' . Currency::where('iso', '!=', $this->baseCurrency->iso)->pluck('iso')->implode(',');

        try {
            $rawResponse = file_get_contents($url);
            $parsedResponse = json_decode($rawResponse, true);
            abort_unless(Arr::get($parsedResponse, 'base') === $this->baseCurrency->iso, 1);
            abort_unless(is_array(Arr::get($parsedResponse, 'rates')), 2);
        } catch (Exception $exception) {
            throw new Exception(
                'Rate download failed at [' . $url . '], got answer "' . ($rawResponse ?? '') . '".',
                $exception->getCode(),
                $exception
            );
        }

        return collect(Arr::get($parsedResponse, 'rates'));
    }
}
