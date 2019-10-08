<?php

return [

    'account' => [
        'currency_iso' => 'devise',
        'name' => 'nom',
        'bank' => 'banque',
    ],

    'envelope' => [
        'name' => 'nom',
        'icon' => 'icône',
        'default_allocation_amount' => 'montant de l\'allocation par défaut',
        'default_allocation_currency_iso' => 'devise de l\'allocation par défaut',
    ],

    'operation' => [
        'type' => 'Type',
        'from_account_id' => 'Compte débiteur',
        'to_account_id' => 'Compte créditeur',
        'from_envelope_id' => 'Envelope débitrice',
        'to_envelope_id' => 'Envelope créditrice',
        'currency_iso' => 'Devise',
        'name' => 'Intitulé',
        'amount' => 'Montant',
        'date' => 'Date',
    ],

];
