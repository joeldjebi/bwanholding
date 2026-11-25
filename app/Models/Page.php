<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['titre', 'slug', 'contenu', 'meta_title', 'meta_description', 'og_image'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
