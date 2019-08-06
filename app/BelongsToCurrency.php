<?php

namespace App;

trait BelongsToCurrency
{
    /**
     * Get the currency that owns the account.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, $this->currencyKey);
    }

    /**
     * Get the currency that owns the account from cache.
     *
     * @return Currency
     */
    public function getCachedCurrencyAttribute() : Currency
    {
        return Currency::fromCache($this->{$this->currencyKey});
    }
}
