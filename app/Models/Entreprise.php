<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entreprise extends Model
{
    protected $fillable = ['nom', 'slug', 'logo', 'domaine_id', 'description', 'services', 'cible', 'statut', 'ordre'];

    protected function casts(): array
    {
        return ['services' => 'array'];
    }

    public function domaine(): BelongsTo
    {
        return $this->belongsTo(Domaine::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
