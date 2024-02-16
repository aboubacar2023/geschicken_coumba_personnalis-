<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reception extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_reception',
        'quantite',
        'prix_unitaire',
        'montant',
        'type_produit',
        'reglement',
        'date_reception',
        'montant_non_regle',
        'date_reglement',
        'fournisseur_id'
    ];

    public function fournisseur() : BelongsTo{
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
}
