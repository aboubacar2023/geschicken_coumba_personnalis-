<?php

use App\Models\Client;
use App\Models\Commande;
use App\Models\Stock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('id_commande');
            $table->date('date_commande');
            $table->integer('montant_commande');
            $table->integer('montant_non_regle_type');
            $table->date('date_reglement')->nullable();
            $table->timestamps();
            $table->foreignIdFor(Client::class)->constrained()->cascadeOnDelete();
        });

        Schema::create('commande_stock', function (Blueprint $table){
            $table->foreignIdFor(Stock::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Commande::class)->constrained()->cascadeOnDelete();
            $table->double('quantite_type');
            $table->integer('prix_unitaire_type');
            $table->integer('montant_type');
            $table->primary(['commande_id', 'stock_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_stock');
        Schema::dropIfExists('commandes');
    }
};
