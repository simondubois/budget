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
        'balance',
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
     * Calculate the monthly balance for the given currency and date.
     *
     * @return float
     */
    public function calculateBalanceAggregate(Currency $currency, Carbon $date) : float
    {
        $period = [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()];

        return $this->allocations()->where('currency_iso', $currency->iso)->whereBetween('date', $period)->sum('amount')
            - $this->expenses()->where('currency_iso', $currency->iso)->whereBetween('date', $period)->sum('amount')
            + $this->incomes()->where('currency_iso', $currency->iso)->whereBetween('date', $period)->sum('amount');
    }
}
