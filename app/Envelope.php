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
}
