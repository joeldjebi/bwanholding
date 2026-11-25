<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['nom', 'entreprise', 'email', 'telephone', 'sujet', 'type_demande', 'message', 'statut'];
}
