<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domaine extends Model
{
    protected $fillable = ['nom', 'slug', 'icone', 'description', 'ordre'];

    public function entreprises(): HasMany
    {
        return $this->hasMany(Entreprise::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
