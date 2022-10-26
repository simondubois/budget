<?php

namespace App;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class Aggregate extends Model
{
    use BelongsToCurrency;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'aggregatable_id' => 'integer',
        'amount' => 'float',
        'date' => 'date',
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
    protected $fillable = [
        'currency_iso',
        'name',
        'date',
        'amount',
    ];

    /**
     * Get the operation amount as Money.
     *
     * @return Money
     */
    public function getAmountAsMoneyAttribute() : Money
    {
        return new Money(
            $this->amount,
            $this->cached_currency,
            CarbonPeriod::create($this->date->copy()->startOfMonth(), $this->date->copy()->endOfMonth())
        );
    }
}
