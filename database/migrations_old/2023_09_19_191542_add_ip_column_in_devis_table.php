<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpColumnInDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->string('lastname')->nullable()->change();
            $table->string('firstname')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->text('content')->nullable()->change();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
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
            $table->string('lastname')->change();
            $table->string('firstname')->change();
            $table->string('email')->change();
            $table->text('content')->change();
            $table->dropColumn('ip_address');
            $table->dropColumn('user_agent');
        });
    }
}
