<?php

use Illuminate\Database\Seeder;

// @codingStandardsIgnoreLine
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CurrenciesTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(EnvelopesTableSeeder::class);
        $this->call(RatesTableSeeder::class);
    }
}
