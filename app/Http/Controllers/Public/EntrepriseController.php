<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Domaine;
use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index(Request $request)
    {
        $domaine = $request->string('domaine')->toString();

        return view('public.entreprises.index', [
            'seo' => [
                'title' => 'Entreprises & Startups - BWAN HOLDING',
                'description' => 'Filiales, startups et marques opérées par BWAN HOLDING.',
            ],
            'domaines' => Domaine::query()->orderBy('ordre')->get(),
            'entreprises' => Entreprise::query()
                ->with('domaine')
                ->when($domaine, fn ($query) => $query->whereHas('domaine', fn ($q) => $q->where('slug', $domaine)))
                ->orderBy('ordre')
                ->paginate(9)
                ->withQueryString(),
            'selectedDomaine' => $domaine,
        ]);
    }

    public function show(Entreprise $entreprise)
    {
        $entreprise->load('domaine');

        return view('public.entreprises.show', [
            'seo' => [
                'title' => $entreprise->nom.' - BWAN HOLDING',
                'description' => str($entreprise->description)->stripTags()->limit(155)->toString(),
            ],
            'entreprise' => $entreprise,
        ]);
    }
}
