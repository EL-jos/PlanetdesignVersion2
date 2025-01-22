<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableArticleMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_material', function (Blueprint $table) {
            $table->uuid('article_id');
            $table->unsignedBigInteger('material_id');
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('material_id')->references('id')->on('materials')
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
        Schema::dropIfExists('article_material');
    }
}
