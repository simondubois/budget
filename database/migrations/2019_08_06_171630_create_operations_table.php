<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// @codingStandardsIgnoreLine
class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     * @SuppressWarnings(PHPMD.ShortMethodName)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_account_id')->nullable()->index();
            $table->unsignedBigInteger('to_account_id')->nullable()->index();
            $table->unsignedBigInteger('from_envelope_id')->nullable()->index();
            $table->unsignedBigInteger('to_envelope_id')->nullable()->index();
            $table->string('currency_iso', 3)->index();
            $table->string('name')->default('');
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
        Schema::dropIfExists('operations');
    }
}
