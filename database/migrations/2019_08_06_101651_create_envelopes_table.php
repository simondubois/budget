<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// @codingStandardsIgnoreLine
class CreateEnvelopesTable extends Migration
{
    /**
     * Run the migrations.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envelopes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('icon');
            $table->decimal('default_allocation_amount', 13, 2);
            $table->string('default_allocation_currency_iso', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('envelopes');
    }
}
