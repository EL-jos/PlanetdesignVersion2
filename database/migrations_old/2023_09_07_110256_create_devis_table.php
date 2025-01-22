<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email');
            $table->string('company')->nullable();
            $table->text('content');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('color_id');
            $table->integer('quantity')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('color_id')->references('id')->on('colors')
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
        Schema::dropIfExists('devis');
    }
}
