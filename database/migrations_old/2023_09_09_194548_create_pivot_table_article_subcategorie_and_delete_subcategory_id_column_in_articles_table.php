<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotTableArticleSubcategorieAndDeleteSubcategoryIdColumnInArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_subcategory', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('subcategory_id');

            $table->foreign('article_id')->references('id')->on('articles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('subcategory_id')->references('id')->on('subcategories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::table('articles', function (Blueprint $table){
            $table->dropForeign('articles_subcategory_id_foreign');
            $table->dropColumn('subcategory_id');
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
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->after('id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
}
