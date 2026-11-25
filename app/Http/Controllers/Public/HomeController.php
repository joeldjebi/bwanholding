<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ChiffreCle;
use App\Models\ContactMessage;
use App\Models\Domaine;
use App\Models\Entreprise;
use App\Models\Partenaire;
use App\Models\Realisation;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('public.home', [
            'seo' => [
                'title' => 'BWAN HOLDING - Groupe multisectoriel africain',
                'description' => 'Technologie, automobile, évènementiel, formation et tourisme au service des ambitions africaines.',
            ],
            'domaines' => Domaine::query()->orderBy('ordre')->take(5)->get(),
            'chiffres' => ChiffreCle::query()->orderBy('ordre')->get(),
            'entreprises' => Entreprise::query()->with('domaine')->orderBy('ordre')->take(6)->get(),
            'realisations' => Realisation::query()->latest()->take(3)->get(),
            'partenaires' => Partenaire::query()->orderBy('ordre')->take(12)->get(),
        ]);
    }

    public function contact(StoreContactMessageRequest $request)
    {
        ContactMessage::create($request->validated());

        return back()->with('success', 'Votre message a bien été transmis. Notre équipe revient vers vous rapidement.');
    }
}
