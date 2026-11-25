<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OffreEmploi extends Model
{
    protected $fillable = ['titre', 'slug', 'entite', 'type_contrat', 'localisation', 'description', 'statut', 'date_publication'];

    protected function casts(): array
    {
        return ['date_publication' => 'date'];
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'offre_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
