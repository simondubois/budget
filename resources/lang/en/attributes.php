<?php

return [

    'account' => [
        'currency_iso' => 'currency',
        'name' => 'name',
        'bank' => 'bank',
    ],

    'envelope' => [
        'name' => 'name',
        'icon' => 'icon',
        'default_allocation_amount' => 'currency amount for the default allocation',
        'default_allocation_currency_iso' => 'currency iso for the default allocation',
    ],

    'operation' => [
        'type' => 'Type',
        'from_account_id' => 'Account in debt',
        'to_account_id' => 'Account in credit',
        'from_envelope_id' => 'Envelope in debt',
        'to_envelope_id' => 'Envelope in credit',
        'currency_iso' => 'Currency',
        'name' => 'Label',
        'amount' => 'Amount',
        'date' => 'Date',
    ],

];
