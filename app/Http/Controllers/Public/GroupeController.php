<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class GroupeController extends Controller
{
    public function __invoke()
    {
        return view('public.groupe', [
            'seo' => [
                'title' => 'Le Groupe - BWAN HOLDING',
                'description' => 'Découvrez la vision, la mission, les valeurs, l’histoire et la gouvernance de BWAN HOLDING.',
            ],
        ]);
    }
}
