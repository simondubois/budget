<?php

use App\Account;
use App\Currency;
use Illuminate\Database\Seeder;

// @codingStandardsIgnoreLine
class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::all()->each(function (Currency $currency) {
            $currency->accounts()->saveMany(factory(Account::class, 2)->make());
        });
    }
}
