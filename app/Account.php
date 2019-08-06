<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use BelongsToCurrency;

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
}
