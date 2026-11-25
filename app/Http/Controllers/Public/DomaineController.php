<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Domaine;

class DomaineController extends Controller
{
    public function index()
    {
        return view('public.domaines.index', [
            'seo' => [
                'title' => 'Domaines d’activité - BWAN HOLDING',
                'description' => 'Les cinq pôles de BWAN HOLDING : technologie, automobile, évènementiel, formation et tourisme.',
            ],
            'domaines' => Domaine::query()->orderBy('ordre')->get(),
        ]);
    }
}
