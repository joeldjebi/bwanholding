<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['titre', 'slug', 'contenu', 'image', 'date_publication', 'statut', 'categorie'];

    protected function casts(): array
    {
        return ['date_publication' => 'date'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
