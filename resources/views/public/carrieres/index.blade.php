@extends('layouts.public')

@section('content')
<x-page-hero
    eyebrow="Carrières"
    title="Rejoindre des équipes qui construisent sur le terrain."
    lead="Chez BWAN HOLDING, les talents travaillent sur des projets concrets, dans des secteurs qui transforment le quotidien des organisations et des communautés."
>
    <a href="#offres" class="btn btn-primary">Voir les offres</a>
    <a href="#candidature" class="link-more">Candidature spontanée</a>
</x-page-hero>

<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-5 md:grid-cols-3">
        @foreach ([['Impact opérationnel', 'Travailler sur des projets visibles, mesurables et utiles.', '◎'], ['Culture d’exigence', 'Rigueur, autonomie et qualité dans l’exécution.', '◈'], ['Apprentissage continu', 'Des métiers variés, des terrains différents et une progression constante.', '✦']] as $i => [$label, $text, $icon])
            <article class="tile p-9 md:p-10" data-reveal style="--reveal-delay: {{ $i * 90 }}ms">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-xl text-brand shadow-sm">{{ $icon }}</div>
                <h2 class="title mt-8">{{ $label }}</h2>
                <p class="mt-3 text-[17px] leading-[1.55] text-muted">{{ $text }}</p>
            </article>
        @endforeach
    </div>
</section>

<section id="offres" class="scroll-mt-20 bg-surface py-20 md:py-28">
    <div class="wrap max-w-[960px]">
        <x-section-heading eyebrow="Opportunités" title="Offres d’emploi" />

        <form method="GET" action="{{ route('public.carrieres.index') }}#offres" class="mt-12 grid gap-3 rounded-[24px] bg-white p-3 shadow-[0_1px_2px_rgba(0,0,0,.04)] md:grid-cols-[1fr_1fr_1fr_auto]" data-reveal>
            <label class="sr-only" for="f-entite">Entité</label>
            <select id="f-entite" name="entite" class="field !ring-0 bg-surface"><option value="">Toutes les entités</option>@foreach ($entites as $entite)<option @selected(request('entite') === $entite)>{{ $entite }}</option>@endforeach</select>
            <label class="sr-only" for="f-contrat">Contrat</label>
            <select id="f-contrat" name="type_contrat" class="field !ring-0 bg-surface"><option value="">Tous les contrats</option>@foreach ($contrats->filter() as $contrat)<option @selected(request('type_contrat') === $contrat)>{{ $contrat }}</option>@endforeach</select>
            <label class="sr-only" for="f-loc">Localisation</label>
            <select id="f-loc" name="localisation" class="field !ring-0 bg-surface"><option value="">Toutes les villes</option>@foreach ($localisations->filter() as $localisation)<option @selected(request('localisation') === $localisation)>{{ $localisation }}</option>@endforeach</select>
            <button class="btn btn-primary">Filtrer</button>
        </form>

        <div class="mt-8 overflow-hidden rounded-[28px] bg-white" data-reveal>
            @forelse ($offres as $offre)
                <a href="{{ route('public.carrieres.show', $offre) }}" class="group flex items-center justify-between gap-6 border-b border-black/[.06] px-7 py-7 transition-colors last:border-0 hover:bg-surface/60 md:px-10">
                    <div>
                        <h3 class="text-[19px] leading-snug font-semibold tracking-tight md:text-[21px]">{{ $offre->titre }}</h3>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach (array_filter([$offre->entite, $offre->type_contrat, $offre->localisation]) as $tag)
                                <span class="chip-soft">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    <span class="hidden shrink-0 text-[15px] text-brand md:inline-flex">Postuler <span aria-hidden="true" class="ml-1 transition duration-300 group-hover:translate-x-1">&rsaquo;</span></span>
                    <span aria-hidden="true" class="text-2xl text-subtle md:hidden">&rsaquo;</span>
                </a>
            @empty
                <p class="p-12 text-center text-muted">Aucune offre ouverte pour le moment.</p>
            @endforelse
        </div>
        <div class="mt-12">{{ $offres->links() }}</div>
    </div>
</section>

<section id="candidature" class="section scroll-mt-20">
    <div class="wrap">
        <form method="POST" action="{{ route('public.carrieres.spontaneous') }}" enctype="multipart/form-data" class="tile grid gap-10 p-8 md:grid-cols-[.8fr_1.2fr] md:p-14" data-reveal>
            @csrf
            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
            <div>
                <p class="eyebrow">Candidature spontanée</p>
                <h2 class="headline mt-2">Présentez votre profil.</h2>
                <p class="mt-5 text-[17px] leading-[1.6] text-muted">Envoyez votre CV et expliquez le type de contribution que vous souhaitez apporter au groupe.</p>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="sp-nom" class="field-label">Nom complet</label>
                    <input id="sp-nom" name="nom" required value="{{ old('nom') }}" autocomplete="name" class="field">
                </div>
                <div>
                    <label for="sp-email" class="field-label">Email</label>
                    <input id="sp-email" name="email" required type="email" value="{{ old('email') }}" autocomplete="email" class="field">
                </div>
                <div class="md:col-span-2">
                    <label for="sp-tel" class="field-label">Téléphone <span class="text-subtle">(facultatif)</span></label>
                    <input id="sp-tel" name="telephone" type="tel" value="{{ old('telephone') }}" autocomplete="tel" class="field">
                </div>
                <div class="md:col-span-2">
                    <label for="sp-msg" class="field-label">Votre message</label>
                    <textarea id="sp-msg" name="message" required rows="5" class="field resize-none">{{ old('message') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label for="sp-cv" class="field-label">CV (PDF, DOC, DOCX)</label>
                    <input id="sp-cv" name="cv" required type="file" accept=".pdf,.doc,.docx" class="field">
                </div>
                <div class="md:col-span-2">
                    <button class="btn btn-primary w-full md:w-auto">Envoyer ma candidature</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
