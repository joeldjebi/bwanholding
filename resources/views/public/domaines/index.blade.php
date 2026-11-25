@extends('layouts.public')

@section('content')
@php
    $fallbackDomaines = collect(['Technologie', 'Services Automobile', 'Évènementiel', 'Formation', 'Tourisme'])->map(fn ($nom, $index) => (object) [
        'nom' => $nom,
        'icone' => ['⌁', '◈', '✦', '◎', '◇'][$index],
        'description' => 'Offres spécialisées, services de terrain et accompagnement stratégique pour les organisations africaines.',
    ]);
    $items = $domaines->isNotEmpty() ? $domaines : $fallbackDomaines;
    $services = [
        'Conseil et cadrage',
        'Déploiement opérationnel',
        'Pilotage qualité',
        'Reporting et amélioration',
    ];
@endphp

<x-page-hero
    eyebrow="Domaines d’activité"
    title="Cinq pôles pour construire, opérer et accélérer."
    lead="BWAN HOLDING structure ses activités autour de métiers complémentaires, avec une approche terrain, mesurable et orientée résultat."
>
    <a href="{{ route('public.contact.index') }}" class="btn btn-primary">Parler à une équipe</a>
    <a href="{{ route('public.entreprises.index') }}" class="link-more">Voir les entités</a>
</x-page-hero>

{{-- MÉTHODE --}}
<section class="pb-20 md:pb-28">
    <div class="wrap">
        <div class="grid grid-cols-2 gap-px overflow-hidden rounded-[28px] bg-black/[.06] md:grid-cols-4" data-reveal>
            @foreach (['Comprendre le besoin', 'Assembler les bons métiers', 'Exécuter avec rigueur', 'Mesurer les résultats'] as $i => $step)
                <div class="bg-surface p-7 md:p-9">
                    <p class="gradient-text text-[32px] leading-none font-semibold tracking-tight md:text-[40px]">0{{ $i + 1 }}</p>
                    <p class="mt-4 text-[17px] font-medium leading-snug">{{ $step }}</p>
                </div>
            @endforeach
        </div>
        <p class="meta mt-4 text-center">La méthode BWAN</p>
    </div>
</section>

{{-- PÔLES --}}
<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-5">
        @foreach ($items as $index => $domaine)
            <article @class(['grid overflow-hidden rounded-[28px] md:grid-cols-[.8fr_1.2fr]', 'bg-night text-white' => $index % 2 === 0, 'bg-surface' => $index % 2 === 1]) data-reveal>
                <div class="flex min-h-[220px] flex-col justify-between p-9 md:min-h-[340px] md:p-12">
                    <div @class(['flex h-14 w-14 items-center justify-center rounded-full text-2xl', 'bg-white/10 text-[#e6c27a]' => $index % 2 === 0, 'bg-white text-brand shadow-sm' => $index % 2 === 1])>{{ $domaine->icone ?: '◆' }}</div>
                    <div class="mt-10">
                        <p @class(['text-[13px] font-medium', 'text-white/50' => $index % 2 === 0, 'text-subtle' => $index % 2 === 1])>Pôle {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</p>
                        <h2 class="mt-1 text-[32px] leading-[1.05] font-semibold tracking-[-0.025em] md:text-[44px]">{{ $domaine->nom }}</h2>
                    </div>
                </div>
                <div class="flex flex-col justify-center p-9 pt-0 md:p-12">
                    <p @class(['text-[19px] leading-[1.55]', 'text-white/70' => $index % 2 === 0, 'text-muted' => $index % 2 === 1])>{{ $domaine->description }}</p>
                    <ul class="mt-8 grid gap-x-6 sm:grid-cols-2">
                        @foreach ($services as $service)
                            <li @class(['flex items-center gap-3 border-t py-3.5 text-[15px]', 'border-white/10 text-white/85' => $index % 2 === 0, 'border-black/[.08] text-ink' => $index % 2 === 1])>
                                <span @class(['text-[13px]', 'text-[#6fd3b0]' => $index % 2 === 0, 'text-brand' => $index % 2 === 1])>✓</span>
                                {{ $service }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-8">
                        <a href="{{ route('public.contact.index') }}" @class(['link-more', 'link-more-light' => $index % 2 === 0])>Demander un échange</a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- SYNERGIES --}}
<section class="bg-surface py-20 md:py-28">
    <div class="wrap">
        <x-section-heading eyebrow="Synergies" title="Les pôles travaillent ensemble quand le projet l’exige." />
        <div class="mt-14 grid gap-5 md:grid-cols-3">
            @foreach ([['Diagnostic', 'Identifier les contraintes, les opportunités et le bon niveau d’intervention.'], ['Assemblage', 'Mobiliser les équipes et partenaires utiles autour du projet.'], ['Exécution', 'Livrer, mesurer, apprendre et améliorer.']] as $i => [$label, $text])
                <article class="card p-9" data-reveal style="--reveal-delay: {{ $i * 90 }}ms">
                    <p class="meta">Étape {{ $i + 1 }}</p>
                    <h3 class="title mt-1">{{ $label }}</h3>
                    <p class="mt-3 text-[17px] leading-[1.55] text-muted">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
