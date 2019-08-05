<?php

use App\Currency;
use Faker\Generator as Faker;

$factory->defineAs(Currency::class, 'EUR', function (Faker $faker) : array {
    return [
        'iso' => 'EUR',
        'name' => 'Euro',
        'unit' => '€',
    ];
});

$factory->defineAs(Currency::class, 'SEK', function (Faker $faker) : array {
    return [
        'iso' => 'SEK',
        'name' => 'Svensk krona',
        'unit' => 'kr',
    ];
});

$factory->defineAs(Currency::class, 'USD', function (Faker $faker) : array {
    return [
        'iso' => 'USD',
        'name' => 'United States dollar',
        'unit' => '$',
    ];
});
