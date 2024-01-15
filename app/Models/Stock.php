<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'quantite_stock'
    ];

    public function commandes() : BelongsToMany {
        return $this->belongsToMany(Commande::class)->as('commande_stock')->withPivot('quantite_type', 'prix_unitaire_type', 'montant_type');
    }

    public function problemes() : HasMany {
        return $this->hasMany(Probleme::class);
    }
}
