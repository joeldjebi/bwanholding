<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCandidatureRequest;
use App\Http\Requests\StoreCandidatureSpontaneeRequest;
use App\Models\Candidature;
use App\Models\OffreEmploi;
use Illuminate\Http\Request;

class CarriereController extends Controller
{
    public function index(Request $request)
    {
        return view('public.carrieres.index', [
            'seo' => ['title' => 'Carrières - BWAN HOLDING', 'description' => 'Opportunités, métiers et culture d’entreprise chez BWAN HOLDING.'],
            'offres' => OffreEmploi::query()
                ->where('statut', 'ouverte')
                ->when($request->filled('entite'), fn ($q) => $q->where('entite', $request->query('entite')))
                ->when($request->filled('type_contrat'), fn ($q) => $q->where('type_contrat', $request->query('type_contrat')))
                ->when($request->filled('localisation'), fn ($q) => $q->where('localisation', $request->query('localisation')))
                ->latest('date_publication')
                ->paginate(8)
                ->withQueryString(),
            'entites' => OffreEmploi::query()->select('entite')->whereNotNull('entite')->distinct()->pluck('entite'),
            'contrats' => OffreEmploi::query()->select('type_contrat')->distinct()->pluck('type_contrat'),
            'localisations' => OffreEmploi::query()->select('localisation')->distinct()->pluck('localisation'),
        ]);
    }

    public function show(OffreEmploi $offreEmploi)
    {
        return view('public.carrieres.show', [
            'seo' => ['title' => $offreEmploi->titre.' - Carrières BWAN HOLDING', 'description' => str($offreEmploi->description)->stripTags()->limit(155)->toString()],
            'offre' => $offreEmploi,
        ]);
    }

    public function apply(StoreCandidatureRequest $request, OffreEmploi $offreEmploi)
    {
        $data = $request->validated();
        $data['offre_id'] = $offreEmploi->id;
        $data['cv_path'] = $request->file('cv')->store('candidatures', $this->candidateDisk());
        unset($data['cv']);

        Candidature::create($data);

        return back()->with('success', 'Votre candidature a bien été envoyée.');
    }

    public function spontaneous(StoreCandidatureSpontaneeRequest $request)
    {
        $data = $request->validated();
        $data['cv_path'] = $request->file('cv')->store('candidatures/spontanees', $this->candidateDisk());
        unset($data['cv']);

        Candidature::create($data);

        return back()->with('success', 'Votre candidature spontanée a bien été envoyée.');
    }

    private function candidateDisk(): string
    {
        return config('filesystems.disks.wasabi.key') ? 'wasabi' : 'public';
    }
}
