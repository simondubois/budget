<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envelope extends Model
{
    use BelongsToCurrency;

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
     *
     * @var array
     */
    protected $fillable = ['name', 'icon', 'default_allocation_amount', 'default_allocation_currency_iso'];
}
