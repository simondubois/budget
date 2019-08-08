<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

// @codingStandardsIgnoreLine
class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('rate:fetch');
    }
}
