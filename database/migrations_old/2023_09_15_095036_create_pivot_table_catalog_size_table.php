<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableCatalogSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_size', function (Blueprint $table) {
            $table->string('catalog_id');
            $table->unsignedBigInteger('size_id');

            $table->foreign('catalog_id')->references('id')->on('catalogs')
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
        Schema::dropIfExists('catalog_size');
    }
}
