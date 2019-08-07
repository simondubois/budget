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
}
