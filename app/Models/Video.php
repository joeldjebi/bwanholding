<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['titre', 'description', 'url_embed', 'thumbnail', 'date'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }
}
