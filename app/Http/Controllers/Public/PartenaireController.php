<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;

class PartenaireController extends Controller
{
    public function __invoke()
    {
        return view('public.partenaires', [
            'seo' => ['title' => 'Partenaires - BWAN HOLDING', 'description' => 'Écosystème technique, institutionnel et commercial de BWAN HOLDING.'],
            'partenaires' => Partenaire::query()->orderBy('categorie')->orderBy('ordre')->get()->groupBy('categorie'),
        ]);
    }
}
