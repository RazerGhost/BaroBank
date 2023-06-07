<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration
{
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->char('id', 36);
            $table->string('currency_from', 3);
            $table->string('currency_to', 3);
            $table->decimal('rate', 8, 5);
            $table->dateTime('datetime');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
}
