<?php

namespace App\Console\Commands;

use App\Account;
use App\Currency;
use App\Envelope;
use App\Operation;
use Artisan;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use stdClass;

class ImportV2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v2:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import database from V2.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (env('APP_ENV') !== 'local') {
            $this->error('APP_ENV must be set to "local" for the import to run.');
            return;
        }

        Cache::forget('currencies');

        $this->migrateDatabase();
        $this->migrateCurrencies();
        $this->migrateAccounts();
        $this->migrateEnvelopes();
        $this->migrateIncomes();
        $this->migrateOutcomes();
        $this->migrateRevenues();
        $this->migrateTransfers();
    }

    /**
     * Restore database structure.
     *
     * @return void
     */
    protected function migrateDatabase()
    {
        $this->info('Migrate database structure...');

        Artisan::call('migrate:refresh');
    }

    /**
     * Migrate data from the currencies table.
     *
     * @return void
     */
    protected function migrateCurrencies()
    {
        $this->info('Migrate table currencies...');

        $this->currencyMap = collect([
            1 => factory(Currency::class, 'EUR')->create(),
            2 => factory(Currency::class, 'SEK')->create(),
        ]);
    }

    /**
     * Migrate data from the accounts table.
     *
     * @return void
     */
    protected function migrateAccounts()
    {
        $this->info('Migrate table accounts...');

        $bankMap = [
            'EUR' => 'Crédit Coopératif',
            'SEK' => 'Sparbanken',
        ];

        $this->accountMap = DB::connection('mysql-v2')
            ->table('accounts')
            ->get()
            ->keyBy('id')
            ->map(function (stdClass $account) use ($bankMap) : array {
                return collect($account)
                    ->forget('id')
                    ->put('currency_iso', $this->currencyMap->get($account->currency_id)->iso)
                    ->forget('currency_id')
                    ->put('bank', $bankMap[$this->currencyMap->get($account->currency_id)->iso])
                    ->toArray();
            })
            ->mapInto(Account::class)
            ->each->save();
    }

    /**
     * Migrate data from the accounts table.
     *
     * @return void
     */
    protected function migrateEnvelopes()
    {
        $this->info('Migrate table envelopes...');

        $iconMap = [
            1 => 'fa-home',
            2 => 'fa-bus',
            3 => 'fa-utensils',
            4 => 'fa-stethoscope',
            5 => 'fa-tshirt',
            6 => 'fa-book',
            7 => 'fa-gifts',
            8 => 'fa-campground',
            9 => 'fa-university',
            10 => 'fa-chalkboard-teacher',
            15 => 'fa-school',
            37 => 'fa-hand-holding-usd',
            38 => 'fa-truck-loading',
            39 => 'fa-bicycle',
            50 => 'fa-female',
            53 => 'fa-pills',
            54 => 'fa-train',
            55 => 'fa-male',
        ];

        $this->envelopeMap = DB::connection('mysql-v2')
            ->table('envelopes')
            ->get()
            ->keyBy('id')
            ->map(function (stdClass $envelope) use ($iconMap) : array {
                return collect($envelope)
                    ->put('icon', $iconMap[$envelope->id])
                    ->put('default_allocation_amount', $envelope->default_income * 10)
                    ->put('default_allocation_currency_iso', 'SEK')
                    ->toArray();
            })
            ->mapInto(Envelope::class)
            ->each->save();
    }

    /**
     * Migrate data from the incomes table.
     *
     * @return void
     */
    protected function migrateIncomes()
    {
        $this->info('Migrate table incomes...');

        DB::connection('mysql-v2')
            ->table('incomes')
            ->get()
            ->map(function (stdClass $income) : array {
                return collect($income)
                    ->put('to_envelope_id', $this->envelopeMap->get($income->envelope_id)->id)
                    ->put('currency_iso', $this->currencyMap->get($income->currency_id)->iso)
                    ->put('name', '')
                    ->toArray();
            })
            ->mapInto(Operation::class)
            ->each->save();
    }

    /**
     * Migrate data from the outcomes table.
     *
     * @return void
     */
    protected function migrateOutcomes()
    {
        $this->info('Migrate table outcomes...');

        DB::connection('mysql-v2')
            ->table('outcomes')
            ->get()
            ->map(function (stdClass $outcome) : array {
                return collect($outcome)
                    ->put('from_account_id', $this->accountMap->get($outcome->account_id)->id)
                    ->put('from_envelope_id', $this->envelopeMap->get($outcome->envelope_id)->id)
                    ->put('currency_iso', $this->accountMap->get($outcome->account_id)->currency_iso)
                    ->toArray();
            })
            ->mapInto(Operation::class)
            ->each->save();
    }

    /**
     * Migrate data from the revenues table.
     *
     * @return void
     */
    protected function migrateRevenues()
    {
        $this->info('Migrate table revenues...');

        DB::connection('mysql-v2')
            ->table('revenues')
            ->get()
            ->map(function (stdClass $revenue) : array {
                return collect($revenue)
                    ->put('to_account_id', $this->accountMap->get($revenue->account_id)->id)
                    ->put('to_envelope_id', $this->envelopeMap->get($revenue->envelope_id, new Envelope())->id)
                    ->put('currency_iso', $this->accountMap->get($revenue->account_id)->currency_iso)
                    ->put('name', $revenue->name ?: 'Solde initial')
                    ->put('date', $revenue->date ?? Carbon::create(2015, 7, 1))
                    ->toArray();
            })
            ->mapInto(Operation::class)
            ->each->save();
    }

    /**
     * Migrate data from the transfers table.
     *
     * @return void
     */
    protected function migrateTransfers()
    {
        $this->info('Migrate table transfers...');

        DB::connection('mysql-v2')
            ->table('transfers')
            ->get()
            ->map(function (stdClass $transfer) : array {
                return collect($transfer)
                    ->put('to_account_id', $this->accountMap->get($transfer->to_account_id)->id)
                    ->put('from_account_id', $this->accountMap->get($transfer->from_account_id)->id)
                    ->put('currency_iso', $this->accountMap->get($transfer->to_account_id)->currency_iso)
                    ->toArray();
            })
            ->mapInto(Operation::class)
            ->each->save();
    }
}
