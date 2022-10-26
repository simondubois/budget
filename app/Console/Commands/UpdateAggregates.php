<?php

namespace App\Console\Commands;

use App\Account;
use App\Aggregate;
use App\Envelope;
use App\Operation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UpdateAggregates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aggregate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update aggregates for all accounts and envelopes.';

    /**
     * The period to update.
     *
     * @var CarbonPeriod
     */
    protected $period;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->period = CarbonPeriod::create(
            Carbon::yesterday()->min(Operation::min('date'))->min(Aggregate::min('date'))->startOfMonth(),
            '1 month',
            Carbon::today()->max(Operation::max('date'))->max(Aggregate::max('date'))->endOfMonth()
        );

        Account::all()->each([$this, 'updateAggregate']);
        Envelope::all()->each([$this, 'updateAggregate']);
    }

    public function updateAggregate(Model $model) : void
    {
        $this->info(get_class($model) . " [$model->id] $model->name");

        $bar = $this->output->createProgressBar($this->period->count());

        foreach ($this->period as $date) {
            $model->updateAggregates($date);
            $bar->advance();
        }

        $bar->finish();
        $this->output->write(chr(27) . "[0G");
        $this->output->write(str_repeat(' ', 42));
        $this->output->write(chr(27) . "[0G");
    }
}
