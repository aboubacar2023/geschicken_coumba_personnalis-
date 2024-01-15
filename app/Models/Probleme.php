<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Probleme extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantite', 
        'type_probleme',
        'stock_id'
    ];

    public function stock() : BelongsTo {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
