<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('catalog_id');
            $table->uuidMorphs('catalogable');
            $table->timestamps();

            $table->foreign('catalog_id')->references('id')->on('catalogs')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('catalogs', function (Blueprint $table) {
            $table->dropForeign('catalogs_article_id_foreign');
            $table->dropColumn('article_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_items');
        Schema::table('catalogs', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreign('article_id')->references('id')->on('articles')
                ->nullOnDelete()->cascadeOnUpdate();
        });
    }
}
