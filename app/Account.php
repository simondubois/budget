<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use BelongsToCurrency;
    use MorphManyAggregates {
        compute as computeTrait;
    }

    /**
     * Operation relations used to calculate aggregates.
     *
     * @var array
     */
    protected $aggregateNames = [
        'directIncomes',
        'expenses',
        'incomes',
        'incomingTransfers',
        'outgoingTransfers',
        'balance',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Foreign key for the currency relation.
     *
     * @var string
     */
    protected $currencyKey = 'currency_iso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['currency_iso', 'name', 'bank'];

    /**
     * Get the direct income operations for the account.
     */
    public function directIncomes()
    {
        return $this->hasMany(Operation::class, 'to_account_id')
            ->whereNull('from_account_id')
            ->whereNull('to_envelope_id');
    }

    /**
     * Get the expense operations for the account.
     */
    public function expenses()
    {
        return $this->hasMany(Operation::class, 'from_account_id')
            ->whereNull('to_account_id');
    }

    /**
     * Get the income operations for the account.
     */
    public function incomes()
    {
        return $this->hasMany(Operation::class, 'to_account_id')
            ->whereNull('from_account_id');
    }

    /**
     * Get the incoming transfer operations for the account.
     */
    public function incomingTransfers()
    {
        return $this->hasMany(Operation::class, 'to_account_id')
            ->whereNotNull('from_account_id');
    }

    /**
     * Get the outgoing transfer operations for the account.
     */
    public function outgoingTransfers()
    {
        return $this->hasMany(Operation::class, 'from_account_id')
            ->whereNotNull('to_account_id');
    }

    /**
     * Calculate the account aggregates for the given period.
     *
     * @param string $name
     * @param CarbonPeriod $period
     * @return Money
     */
    public function compute(string $name, CarbonPeriod $period) : Money
    {
        return new Money(
            $this->computeTrait($name, $period)->amounts->get($this->cached_currency->iso),
            $this->cached_currency,
            CarbonPeriod::create($period->getEndDate()->copy()->startOfMonth(), $period->getEndDate())
        );
    }

    /**
     * Calculate global account aggregates for the given period.
     *
     * @param string $name
     * @param CarbonPeriod $period
     * @return Money
     */
    public static function computeGlobal(string $name, CarbonPeriod $period) : Money
    {
        return Money::sum(
            Account::all()->map(function (Account $account) use ($name, $period) {
                return $account->compute($name, $period);
            })
        );
    }

    /**
     * Calculate the monthly balance for the given currency and date.
     *
     * @return float
     */
    public function calculateBalanceAggregate(Currency $currency, Carbon $date) : float
    {
        $period = [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()];

        return $this->incomes()->where('currency_iso', $currency->iso)->whereBetween('date', $period)->sum('amount')
            - $this->expenses()->where('currency_iso', $currency->iso)->whereBetween('date', $period)->sum('amount')
            + $this->incomingTransfers()
                ->where('currency_iso', $currency->iso)
                ->whereBetween('date', $period)
                ->sum('amount')
            - $this->outgoingTransfers()
                ->where('currency_iso', $currency->iso)
                ->whereBetween('date', $period)
                ->sum('amount');
    }
}
