<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Currency extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'iso';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the accounts for the currency.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Get the rates for the currency.
     */
    public function rates()
    {
        return $this->hasMany(Rate::class, 'base_currency_iso');
    }

    /**
     * Get one or all currencies from cache.
     *
     * @param string $isoCode
     * @return Collection|Currency
     */
    public static function fromCache(string $isoCode = null)
    {
        return
            Cache::rememberForever('currencies', function () {
                return Currency::all();
            })
            ->when($isoCode, function (Collection $currencies, string $isoCode) {
                return $currencies->find($isoCode);
            });
    }
}
