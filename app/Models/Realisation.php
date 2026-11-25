<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realisation extends Model
{
    protected $fillable = ['titre', 'slug', 'secteur', 'problematique', 'solution', 'resultat', 'images', 'video_url'];

    protected function casts(): array
    {
        return ['images' => 'array'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
