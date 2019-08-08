<?php

namespace App\Console\Commands;

use App\Currency;
use App\Jobs\FetchRate;
use App\Operation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FetchRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch missing currency rates for all currencies.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Currency::fromCache()
            ->crossJoin($this->getPeriod())
            ->filter([$this, 'incompleteRates'])
            ->tap([$this, 'startProgressbar'])
            ->eachSpread([$this, 'dispatchJob'])
            ->tap([$this, 'stopProgressbar']);
    }

    public function getPeriod() : Collection
    {
        $start = Carbon::yesterday()->min(Operation::oldest('date')->value('date'));
        $end = Carbon::yesterday();

        return collect(
            CarbonPeriod::since($start)->until($end)
        );
    }

    public function incompleteRates(array $data) : bool
    {
        $existingRateCount = $data[0]->rates()->where('date', $data[1])->count();
        $requiredRateCount = Currency::fromCache()->count() - 1;

        return $existingRateCount < $requiredRateCount;
    }

    public function startProgressbar(Collection $data) : void
    {
        if ($data->isEmpty()) {
            $this->info('No currency rate to download.');
            return;
        }

        $this->info($data->count() . ' currency rates to download.');

        $this->bar = $this->output->createProgressBar($data->count());
    }

    public function dispatchJob(Currency $baseCurrency, Carbon $date) : void
    {
        FetchRate::dispatch($baseCurrency, $date);

        $this->bar->advance();
    }

    public function stopProgressbar(Collection $data) : void
    {
        if ($data->isEmpty()) {
            return;
        }

        $this->bar->finish();
        $this->line('');
    }

}
