<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Realisation;
use Illuminate\Http\Request;

class RealisationController extends Controller
{
    public function index(Request $request)
    {
        $secteur = $request->string('secteur')->toString();

        return view('public.realisations.index', [
            'seo' => [
                'title' => 'Réalisations - BWAN HOLDING',
                'description' => 'Projets, missions et résultats récents portés par les équipes de BWAN HOLDING.',
            ],
            'secteurs' => Realisation::query()->select('secteur')->distinct()->pluck('secteur'),
            'realisations' => Realisation::query()
                ->when($secteur, fn ($query) => $query->where('secteur', $secteur))
                ->latest()
                ->paginate(9)
                ->withQueryString(),
            'selectedSecteur' => $secteur,
        ]);
    }

    public function show(Realisation $realisation)
    {
        return view('public.realisations.show', [
            'seo' => [
                'title' => $realisation->titre.' - Réalisation BWAN HOLDING',
                'description' => str($realisation->resultat ?: $realisation->solution)->stripTags()->limit(155)->toString(),
            ],
            'realisation' => $realisation,
        ]);
    }
}
