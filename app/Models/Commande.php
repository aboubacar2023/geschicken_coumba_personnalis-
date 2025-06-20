<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_commande',
        'date_commande',
        'montant_commande',
        'montant_non_regle_type',
        'client_id',
        'date_reglement'
    ];

    public function client() : BelongsTo {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function stocks() : BelongsToMany {
        return $this->belongsToMany(Stock::class)->as('commande_stock')->withPivot('quantite_type', 'prix_unitaire_type', 'montant_type');
    }
}
