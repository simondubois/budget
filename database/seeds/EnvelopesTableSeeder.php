<?php

use App\Envelope;
use Illuminate\Database\Seeder;

// @codingStandardsIgnoreLine
class EnvelopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Envelope::class)->create(['name' => 'Housing', 'icon' => 'fa-home']);
        factory(Envelope::class)->create(['name' => 'Transport', 'icon' => 'fa-car']);
        factory(Envelope::class)->create(['name' => 'Food', 'icon' => 'fa-utensils']);
        factory(Envelope::class)->create(['name' => 'Health', 'icon' => 'fa-stethoscope']);
        factory(Envelope::class)->create(['name' => 'Clothes', 'icon' => 'fa-tshirt']);
        factory(Envelope::class)->create(['name' => 'Books', 'icon' => 'fa-book']);
        factory(Envelope::class)->create(['name' => 'Gifts', 'icon' => 'fa-gifts']);
        factory(Envelope::class)->create(['name' => 'Vacations', 'icon' => 'fa-umbrella-beach']);
        factory(Envelope::class)->create(['name' => 'Taxes', 'icon' => 'fa-university']);
        factory(Envelope::class)->create(['name' => 'Charity', 'icon' => 'fa-hand-holding-usd']);
        factory(Envelope::class)->create(['name' => 'Pets', 'icon' => 'fa-paw']);
        factory(Envelope::class)->create(['name' => 'Cinema', 'icon' => 'fa-film']);
        factory(Envelope::class)->create(['name' => 'Sport', 'icon' => 'fa-futbol']);
        factory(Envelope::class)->create(['name' => 'Motorbike', 'icon' => 'fa-motorcycle']);
        factory(Envelope::class)->create(['name' => 'Tech', 'icon' => 'fa-phone']);
    }
}
