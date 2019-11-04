<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aggregate extends Model
{
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
}
