<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_operation',
        'montant_operation',
        'caisse_id',
    ];

    public function caisse() : BelongsTo {
        return $this->belongsTo(Caisse::class, 'caisse_id');
    }
}
