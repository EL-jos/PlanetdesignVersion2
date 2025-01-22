<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableSizeQuote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('size_quote', function (Blueprint $table) {
            $table->string('quote_id');
            $table->unsignedBigInteger('size_id');

            $table->foreign('quote_id')->references('id')->on('quotes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('size_id')->references('id')->on('sizes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('size_quote');
    }
}
