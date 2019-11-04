<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Envelope extends Model
{
    use BelongsToCurrency;
    use MorphManyAggregates;

    /**
     * Operation relations used to calculate aggregates.
     *
     * @var array
     */
    protected $aggregateNames = [
        'allocations',
        'expenses',
        'incomes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'default_allocation_amount' => 'float',
    ];

    /**
     * Foreign key for the currency relation.
     *
     * @var string
     */
    protected $currencyKey = 'default_allocation_currency_iso';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = ['name', 'icon', 'default_allocation_amount', 'default_allocation_currency_iso'];

    /**
     * Get the allocation operations for the envelope.
     */
    public function allocations()
    {
        return $this->hasMany(Operation::class, 'to_envelope_id')
            ->whereNull('to_account_id');
    }

    /**
     * Get the expense operations for the envelope.
     */
    public function expenses()
    {
        return $this->hasMany(Operation::class, 'from_envelope_id');
    }

    /**
     * Get the income operations for the envelope.
     */
    public function incomes()
    {
        return $this->hasMany(Operation::class, 'to_envelope_id')
            ->whereNotNull('to_account_id');
    }

    /**
     * Calculate the aggregates for the given period.
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
                $this->computeAggregates('allocations', $min, $max),
                $this->computeAggregates('expenses', $min, $max)->opposite(),
                $this->computeAggregates('incomes', $min, $max),
            ]));
        }

        return $this->computeAggregates($name, $min, $max);
    }

    /**
     * Calculate global envelope aggregates for the given period.
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
                static::computeGlobalAggregates('allocations', $min, $max),
                static::computeGlobalAggregates('expenses', $min, $max)->opposite(),
                static::computeGlobalAggregates('incomes', $min, $max),
            ]));
        }

        return static::computeGlobalAggregates($name, $min, $max);
    }
}
