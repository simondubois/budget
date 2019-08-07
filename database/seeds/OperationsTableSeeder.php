<?php

use App\Envelope;
use App\Operation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

// @codingStandardsIgnoreLine
class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Operation::class, strval(Operation::EXPENSE), 150)->create();

        factory(Operation::class, strval(Operation::INCOME), 200)->create();

        factory(Operation::class, strval(Operation::TRANSFER), 50)->create();

        Envelope::get()
            ->crossJoin(Carbon::today()->subYear()->startOfMonth()->monthsUntil(Carbon::today()))
            ->random(100)
            ->eachSpread(function (Envelope $envelope, Carbon $date) {
                $envelope->allocations()->save(
                    factory(Operation::class, strval(Operation::ALLOCATION))->make(['date' => $date])
                );
            });
    }
}
