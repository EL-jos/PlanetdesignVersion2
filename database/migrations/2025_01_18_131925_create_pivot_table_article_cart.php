<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableArticleCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_cart', function (Blueprint $table) {
            $table->uuid('article_id');
            $table->uuid('cart_id');
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('cart_id')->references('id')->on('carts')
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
        Schema::dropIfExists('article_cart');
    }
}
