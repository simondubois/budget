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
        $currencyIso = strtolower($this->baseCurrency->iso);
        $url = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@"
            . "{$this->date->toDateString()}/v1/currencies/$currencyIso.json";

        try {
            $rawResponse = file_get_contents($url);
            $parsedResponse = json_decode($rawResponse, true);
            abort_unless(Arr::has($parsedResponse, $currencyIso), 1);
            abort_unless(is_array(Arr::get($parsedResponse, $currencyIso)), 2);
        } catch (Exception $exception) {
            report(
                new Exception(
                    'Rate download failed at [' . $url . '], got answer "' . ($rawResponse ?? '') . '".',
                    $exception->getCode(),
                    $exception
                )
            );

            return collect();
        }

        return collect(Arr::get($parsedResponse, $currencyIso))
            ->keyBy(function (float $rate, string $currencyIso) : string {
                return strtoupper($currencyIso);
            })
            ->only(Currency::pluck('iso'))
            ->except($this->baseCurrency->iso);
    }
}
