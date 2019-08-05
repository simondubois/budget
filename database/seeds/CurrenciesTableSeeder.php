<?php

use App\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

// @codingStandardsIgnoreLine
class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cache::forget('currencies');

        factory(Currency::class, 'EUR')->create();
        factory(Currency::class, 'SEK')->create();
        factory(Currency::class, 'USD')->create();
    }
}
