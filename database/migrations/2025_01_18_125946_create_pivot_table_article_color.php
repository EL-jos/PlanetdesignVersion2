<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableArticleColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_color', function (Blueprint $table) {
            $table->uuid('article_id');
            $table->unsignedBigInteger('color_id');
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('color_id')->references('id')->on('colors')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_color');
    }
}
