<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caisse extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_caisse',
        'somme_type',
    ];

    public function operations() : HasMany {
        return $this->hasMany(Operation::class);
    }
}
