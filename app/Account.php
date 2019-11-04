<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use BelongsToCurrency;
    use MorphManyAggregates;

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
     * @param Carbon $min
     * @param Carbon $max
     * @return Money
     */
    public function compute(string $name, Carbon $min, Carbon $max) : Money
    {
        if ($name === 'balance') {
            return Money::sum(collect([
                $this->computeAggregates('incomes', $min, $max),
                $this->computeAggregates('expenses', $min, $max)->opposite(),
                $this->computeAggregates('incomingTransfers', $min, $max),
                $this->computeAggregates('outgoingTransfers', $min, $max)->opposite(),
            ]));
        }

        return $this->computeAggregates($name, $min, $max);
    }

    /**
     * Calculate global account aggregates for the given period.
     *
     * @param string $name
     * @param Carbon $min
     * @param Carbon $max
     * @return Money
     */
    public static function computeGlobal(string $name, Carbon $min, Carbon $max) : Money
    {
        if ($name === 'balance') {
            return Money::sum(collect([
                static::computeGlobalAggregates('incomes', $min, $max),
                static::computeGlobalAggregates('expenses', $min, $max)->opposite(),
                static::computeGlobalAggregates('incomingTransfers', $min, $max),
                static::computeGlobalAggregates('outgoingTransfers', $min, $max)->opposite(),
            ]));
        }

        return static::computeGlobalAggregates($name, $min, $max);
    }
}
