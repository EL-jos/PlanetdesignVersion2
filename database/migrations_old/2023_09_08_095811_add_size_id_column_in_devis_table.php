<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeIdColumnInDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->nullable()->change();
            $table->unsignedBigInteger('size_id')->nullable();

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
        Schema::table('devis', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->change();
            $table->dropColumn('size_id');
        });
    }
}
