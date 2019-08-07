<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Operation extends Model
{
    use BelongsToCurrency;

    const HAS_ORIGIN_ACCOUNT = 0b0001;
    const HAS_ORIGIN_ENVELOPE = 0b0010;
    const HAS_RECIPIENT_ACCOUNT = 0b0100;
    const HAS_RECIPIENT_ENVELOPE = 0b1000;

    const ALLOCATION = self::HAS_RECIPIENT_ENVELOPE;
    const EXPENSE = self::HAS_ORIGIN_ACCOUNT | self::HAS_ORIGIN_ENVELOPE;
    const INCOME = self::HAS_RECIPIENT_ACCOUNT;
    const TRANSFER = self::HAS_ORIGIN_ACCOUNT | self::HAS_RECIPIENT_ACCOUNT;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'from_account_id' => 'integer',
        'to_account_id' => 'integer',
        'from_envelope_id' => 'integer',
        'to_envelope_id' => 'integer',
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
        'from_account_id',
        'to_account_id',
        'from_envelope_id',
        'to_envelope_id',
        'currency_iso',
        'name',
        'amount',
        'date'
    ];

    /**
     * Get the origin account that owns the operation.
     */
    public function originAccount()
    {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    /**
     * Get the origin envelope that owns the operation.
     */
    public function originEnvelope()
    {
        return $this->belongsTo(Envelope::class, 'from_envelope_id');
    }

    /**
     * Get the recipient account that owns the operation.
     */
    public function recipientAccount()
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    /**
     * Get the recipient envelope that owns the operation.
     */
    public function recipientEnvelope()
    {
        return $this->belongsTo(Envelope::class, 'to_envelope_id');
    }

    /**
     * Get the operation amount as Money.
     *
     * @return Money
     */
    public function getAmountAttribute(float $amount) : Money
    {
        return new Money($amount, $this->cached_currency, $this->date);
    }

    /**
     * Get the operation type ID.
     *
     * @return string
     */
    public function getTypeIdAttribute() : int
    {
        return $this->to_account_id && $this->to_envelope_id ? static::HAS_RECIPIENT_ACCOUNT :
            ($this->from_account_id ? static::HAS_ORIGIN_ACCOUNT : 0)
            | ($this->from_envelope_id ? static::HAS_ORIGIN_ENVELOPE : 0)
            | ($this->to_account_id ? static::HAS_RECIPIENT_ACCOUNT : 0)
            | ($this->to_envelope_id ? static::HAS_RECIPIENT_ENVELOPE : 0);
    }

    /**
     * Get the operation type name.
     *
     * @return string
     */
    public function getTypeNameAttribute() : string
    {
        return strtolower(
            collect((new ReflectionClass($this))->getConstants())
                ->flip()
                ->get($this->type_id)
        );
    }
}
