<?php

use App\Currency;
use App\Envelope;
use Faker\Generator as Faker;

$factory->define(Envelope::class, function (Faker $faker) : array {
    return [
        'default_allocation_amount' => $faker->randomFloat(2, 1, 1000),
        'default_allocation_currency_iso' => function () : string {
            return Currency::inRandomOrder()->value('iso');
        },
    ];
});
