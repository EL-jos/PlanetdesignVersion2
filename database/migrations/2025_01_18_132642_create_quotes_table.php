<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id'); // Lien avec l'utilisateur
            $table->enum('status', ['en attente', 'validée', 'annulé', 'En cours', 'terminée', 'remboursée', 'échouée', 'remise en banque', 'paiement différé', 'partiellement remboursé', 'brouillon'])->default('en attente'); // Statut de la commande
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('quotes');
    }
}
