<?php

use App\Models\Fournisseur;
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
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->string('id_reception');
            $table->double('quantite');
            $table->integer('prix_unitaire');
            $table->integer('montant');
            $table->string('type_produit');
            $table->boolean('reglement')->default(false);
            $table->date('date_reglement')->nullable();
            $table->foreignIdFor(Fournisseur::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptions');
    }
};
