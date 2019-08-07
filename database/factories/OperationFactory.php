<?php

use App\Account;
use App\Currency;
use App\Envelope;
use App\Operation;
use Carbon\Carbon;
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

$factory->define(Operation::class, function (Faker $faker) : array {
    return [
        'name' => $faker->catchPhrase,
        'amount' => $faker->randomFloat(2, 1, 1000),
        'date' => Carbon::instance($faker->dateTimeThisYear())->startOfDay(),
    ];
});

$factory->defineAs(Operation::class, Operation::ALLOCATION, function (Faker $faker) use ($factory)  : array {
    return $factory->raw(Operation::class) + [
        'to_envelope_id' => function () : int {
            return Envelope::inRandomOrder()->value('id');
        },
        'currency_iso' => function (array $attributes) : string {
            $operations = Operation::where('date', $attributes['date'])
                ->get()
                ->whereIn('type_name', 'allocation')
                ->first();
            return $operations ? $operations->currency_iso : Currency::inRandomOrder()->value('iso');
        },
    ];
});
$factory->defineAs(Operation::class, Operation::EXPENSE, function (Faker $faker) use ($factory)  : array {
    return $factory->raw(Operation::class) + [
        'from_account_id' => function () : int {
            return Account::inRandomOrder()->value('id');
        },
        'from_envelope_id' => function () : int {
            return Envelope::inRandomOrder()->value('id');
        },
        'currency_iso' => function (array $attributes) : string {
            return Account::find($attributes['from_account_id'])->currency_iso;
        },
    ];
});

$factory->defineAs(Operation::class, Operation::INCOME, function (Faker $faker) use ($factory)  : array {
    return $factory->raw(Operation::class) + [
        'to_account_id' => function () : int {
            return Account::inRandomOrder()->value('id');
        },
        'to_envelope_id' => function () use ($faker) : ?int {
            return $faker->boolean ? Envelope::inRandomOrder()->value('id') : null;
        },
        'currency_iso' => function (array $attributes) : string {
            return Account::find($attributes['to_account_id'])->currency_iso;
        },
    ];
});

$factory->defineAs(Operation::class, Operation::TRANSFER, function (Faker $faker) use ($factory)  : array {
    return $factory->raw(Operation::class) + [
        'from_account_id' => function () : int {
            return Account::inRandomOrder()->value('id');
        },
        'to_account_id' => function (array $attributes) : int {
            return Account::query()
                ->whereKeyNot($attributes['from_account_id'])
                ->where('currency_iso', Account::find($attributes['from_account_id'])->currency_iso)
                ->inRandomOrder()
                ->value('id');
        },
        'currency_iso' => function (array $attributes) : string {
            return Account::find($attributes['from_account_id'])->currency_iso;
        },
    ];
});
