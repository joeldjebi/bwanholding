<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiffreCle extends Model
{
    protected $fillable = ['libelle', 'valeur', 'icone', 'ordre'];
}
