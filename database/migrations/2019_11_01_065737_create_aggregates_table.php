<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// @codingStandardsIgnoreLine
class CreateAggregatesTable extends Migration
{
    /**
     * Run the migrations.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aggregates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('aggregatable');
            $table->string('currency_iso', 3)->index();
            $table->string('name')->index();
            $table->decimal('amount', 13, 2);
            $table->timestamp('date')->nullable()->index();
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
        Schema::dropIfExists('aggregates');
    }
}
