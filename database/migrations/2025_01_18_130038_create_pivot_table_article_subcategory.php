<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableArticleSubcategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_subcategory', function (Blueprint $table) {
            $table->uuid('article_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('subcategory_id')->references('id')->on('subcategories')
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
        Schema::dropIfExists('article_subcategory');
    }
}
