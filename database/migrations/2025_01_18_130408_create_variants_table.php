<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('article_id');
            $table->unsignedBigInteger('availability_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('availability_id')->references('id')->on('availabilities')
                ->cascadeOnUpdate()->cascadeOnDelete();


            $table->foreign('article_id')->references('id')->on('articles')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('color_id')->references('id')->on('colors')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('size_id')->references('id')->on('sizes')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
}
