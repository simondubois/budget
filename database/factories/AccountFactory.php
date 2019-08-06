<?php

use App\Account;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Account::class, function (Faker $faker) : array {
    return [
        'name' => $faker->company,
        'bank' => Account::exists() && $faker->boolean ? Account::inRandomOrder()->value('bank') : $faker->company,
    ];
});
