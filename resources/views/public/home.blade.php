@extends('layouts.public')

@section('content')
@php
    use App\Support\MediaUrl;

    $fallbackImages = [
        'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=2000&q=80',
        'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
    ];
    $realisationImages = $realisations->flatMap(fn ($realisation) => $realisation->images ?: [])->values();

    $domaineItems = $domaines->isNotEmpty()
        ? $domaines
        : collect(['Technologie', 'Services Automobile', 'Évènementiel', 'Formation', 'Tourisme'])->map(fn ($nom) => (object) [
            'nom' => $nom,
            'icone' => null,
            'description' => 'Solutions spécialisées pour accompagner la croissance des organisations.',
        ]);
    // Bento : 2 grandes tuiles puis 3 tuiles
    $bento = ['md:col-span-3', 'md:col-span-3', 'md:col-span-2', 'md:col-span-2', 'md:col-span-2'];

    $chiffreItems = $chiffres->isNotEmpty()
        ? $chiffres->map(fn ($c) => [$c->valeur, $c->libelle])
        : collect([['+10', 'Projets structurants'], ['5', 'Pôles métiers'], ['+20', 'Partenaires'], ['100%', 'Vision africaine']]);
@endphp

{{-- HERO --}}
<section class="relative overflow-hidden bg-white">
    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -top-48 mx-auto h-[560px] max-w-5xl rounded-full bg-[radial-gradient(closest-side,rgba(11,79,63,.10),transparent)] blur-3xl"></div>
    <div class="wrap relative pt-16 text-center md:pt-28">
        <div class="hero-fade">
            <p class="eyebrow">Groupe multisectoriel africain</p>
            <h1 class="display mx-auto mt-3 max-w-5xl">
                Des entreprises solides pour
                <span class="gradient-text">accélérer les marchés africains.</span>
            </h1>
            <p class="lead mx-auto mt-6 max-w-2xl">BWAN HOLDING fédère technologie, automobile, évènementiel, formation et tourisme dans une même logique : bâtir, exploiter et transmettre des plateformes de croissance concrètes.</p>
            <div class="mt-10 flex flex-wrap items-center justify-center gap-x-6 gap-y-4">
                <a href="{{ route('public.groupe') }}" class="btn btn-primary">Découvrir le groupe</a>
                <a href="{{ route('public.contact.index') }}" class="link-more">Nous contacter</a>
            </div>
        </div>
    </div>

    <div class="wrap-wide relative mt-14 md:mt-20" data-reveal>
        <div class="relative overflow-hidden rounded-[28px] bg-surface md:rounded-[40px]">
            <img
                src="{{ MediaUrl::for($realisationImages[0] ?? $fallbackImages[0]) }}"
                alt="Espace professionnel BWAN HOLDING"
                class="aspect-[4/3] w-full object-cover sm:aspect-[16/9] lg:aspect-[21/9]"
                fetchpriority="high"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/0 to-black/0"></div>
            <div class="absolute inset-x-0 bottom-0 grid grid-cols-3 gap-4 p-6 text-white md:p-10">
                @foreach ([['5', 'Pôles métiers'], ['+20', 'Partenaires'], ['360°', 'Exécution']] as [$value, $label])
                    <div>
                        <p class="text-[28px] leading-none font-semibold tracking-tight md:text-[44px]">{{ $value }}</p>
                        <p class="mt-2 text-[12px] text-white/75 md:text-[15px]">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- MANIFESTE --}}
<section class="section">
    <div class="wrap">
        <p class="mx-auto max-w-4xl text-center text-[28px] leading-[1.2] font-semibold tracking-[-0.02em] text-ink md:text-[44px]" data-reveal>
            Investir dans l’exécution, pas seulement dans les idées.
            <span class="text-subtle">Une holding opérationnelle pensée pour les terrains africains.</span>
        </p>
    </div>
</section>

{{-- EXPERTISES --}}
<section class="pb-20 md:pb-28">
    <div class="wrap">
        <x-section-heading eyebrow="Expertises" title="Cinq domaines, une même exigence opérationnelle." />

        <div class="mt-14 grid gap-4 md:grid-cols-6 md:gap-5">
            @foreach ($domaineItems as $i => $domaine)
                <article
                    @class(['tile flex flex-col justify-between p-8 md:p-10', $bento[$i] ?? 'md:col-span-2', 'min-h-[260px] md:min-h-[340px]' => $i < 2, 'min-h-[240px]' => $i >= 2])
                    data-reveal
                    style="--reveal-delay: {{ ($i % 3) * 90 }}ms"
                >
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-xl text-brand shadow-sm">{{ $domaine->icone ?: '◆' }}</div>
                    <div class="mt-10">
                        <p class="meta">Pôle {{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</p>
                        <h3 @class(['mt-1 font-semibold tracking-tight text-ink', 'text-[28px] md:text-[34px]' => $i < 2, 'text-[22px] md:text-[24px]' => $i >= 2])>{{ $domaine->nom }}</h3>
                        <p class="mt-3 max-w-md text-[15px] leading-[1.55] text-muted md:text-[17px]">{{ $domaine->description }}</p>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10 text-center" data-reveal>
            <a href="{{ route('public.domaines.index') }}" class="link-more">Explorer les domaines d’activité</a>
        </div>
    </div>
</section>

{{-- CHIFFRES --}}
<section class="bg-night py-20 text-white md:py-28">
    <div class="wrap">
        <x-section-heading eyebrow="En chiffres" title="Un groupe qui se mesure à ses résultats." :dark="true" />
        <div class="mt-16 grid grid-cols-2 gap-x-6 gap-y-12 md:grid-cols-4">
            @foreach ($chiffreItems as $i => [$value, $label])
                <div class="text-center" data-reveal style="--reveal-delay: {{ $i * 90 }}ms">
                    <p class="gradient-text-light text-[48px] leading-none font-semibold tracking-[-0.03em] md:text-[72px]">{{ $value }}</p>
                    <p class="mt-3 text-[15px] text-white/60 md:text-[17px]">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PORTEFEUILLE --}}
<section class="section">
    <div class="wrap">
        <x-section-heading eyebrow="Portefeuille" title="Entreprises & startups" lead="Les filiales, marques et startups opérées par le groupe.">
            <x-slot:action>
                <a href="{{ route('public.entreprises.index') }}" class="link-more">Tout voir</a>
            </x-slot:action>
        </x-section-heading>

        <div class="mt-14 grid gap-5 md:grid-cols-3">
            @forelse ($entreprises as $i => $entreprise)
                <a href="{{ route('public.entreprises.show', $entreprise) }}" class="card group flex flex-col p-8" data-reveal style="--reveal-delay: {{ ($i % 3) * 90 }}ms">
                    <div class="flex h-20 items-center">
                        @if ($entreprise->logo)
                            <img loading="lazy" src="{{ MediaUrl::for($entreprise->logo) }}" alt="Logo {{ $entreprise->nom }}" class="max-h-16 max-w-40 object-contain">
                        @else
                            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-soft text-xl font-semibold text-brand">{{ mb_substr($entreprise->nom, 0, 1) }}</span>
                        @endif
                    </div>
                    <p class="meta mt-8">{{ $entreprise->domaine?->nom }}</p>
                    <h3 class="title mt-1">{{ $entreprise->nom }}</h3>
                    <p class="mt-3 flex-1 text-[15px] leading-[1.55] text-muted">{{ str($entreprise->description)->limit(120) }}</p>
                    <span class="link-more mt-6 text-[15px]">Découvrir</span>
                </a>
            @empty
                <p class="tile p-10 text-center text-muted md:col-span-3">Les entités du groupe seront publiées prochainement.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- REALISATIONS --}}
<section class="bg-surface py-20 md:py-28">
    <div class="wrap">
        <x-section-heading eyebrow="Réalisations" title="Des missions pilotées avec une logique de résultat." lead="Chaque réalisation associe cadrage, coordination terrain et mesure d’impact pour produire une valeur durable." />

        <div class="mt-14 grid gap-5 md:grid-cols-3">
            @forelse ($realisations as $i => $realisation)
                <a href="{{ route('public.realisations.show', $realisation) }}" class="card media-zoom group flex flex-col" data-reveal style="--reveal-delay: {{ $i * 90 }}ms">
                    <div class="aspect-[4/3] overflow-hidden bg-surface">
                        <img loading="lazy" src="{{ MediaUrl::for(($realisation->images[0] ?? null) ?: $fallbackImages[2]) }}" alt="{{ $realisation->titre }}" class="h-full w-full object-cover">
                    </div>
                    <div class="flex flex-1 flex-col p-7">
                        <p class="meta">{{ $realisation->secteur }}</p>
                        <h3 class="mt-1 text-[21px] leading-tight font-semibold tracking-tight">{{ $realisation->titre }}</h3>
                        <p class="mt-3 flex-1 text-[15px] leading-[1.55] text-muted">{{ str($realisation->resultat)->limit(130) }}</p>
                        <span class="link-more mt-5 text-[15px]">Voir le cas</span>
                    </div>
                </a>
            @empty
                <p class="card p-10 text-center text-muted md:col-span-3">Les réalisations seront ajoutées depuis le back-office.</p>
            @endforelse
        </div>

        <div class="mt-12 text-center" data-reveal>
            <a href="{{ route('public.realisations.index') }}" class="btn btn-secondary">Explorer toutes les réalisations</a>
        </div>
    </div>
</section>

{{-- PARTENAIRES --}}
<section class="section">
    <div class="wrap">
        <x-section-heading eyebrow="Écosystème" title="Ils avancent avec nous.">
            <x-slot:action>
                <a href="{{ route('public.partenaires') }}" class="link-more">Voir l’écosystème</a>
            </x-slot:action>
        </x-section-heading>

        <div class="mt-14 grid grid-cols-2 gap-px overflow-hidden rounded-[28px] bg-black/[.06] sm:grid-cols-3 md:grid-cols-6" data-reveal>
            @forelse ($partenaires as $partenaire)
                <div class="group flex min-h-28 items-center justify-center bg-white p-6 text-center text-[15px] font-medium text-muted">
                    @if ($partenaire->logo)
                        <img loading="lazy" src="{{ MediaUrl::for($partenaire->logo) }}" alt="Logo {{ $partenaire->nom }}" class="max-h-12 max-w-full object-contain opacity-70 grayscale transition duration-500 group-hover:opacity-100 group-hover:grayscale-0">
                    @else
                        {{ $partenaire->nom }}
                    @endif
                </div>
            @empty
                @foreach (range(1, 6) as $i)
                    <div class="flex min-h-28 items-center justify-center bg-white p-6 text-[15px] text-subtle">Partenaire</div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- TALENTS + CONTACT --}}
<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-5 lg:grid-cols-[.9fr_1.1fr]">
        <div class="tile-dark flex flex-col justify-between p-10 md:p-14" data-reveal>
            <div aria-hidden="true" class="pointer-events-none absolute -right-24 -bottom-24 h-80 w-80 rounded-full bg-[radial-gradient(closest-side,rgba(111,211,176,.35),transparent)] blur-2xl"></div>
            <div class="relative">
                <p class="eyebrow !text-[#6fd3b0]">Talents</p>
                <h2 class="headline mt-2">Rejoindre BWAN HOLDING.</h2>
                <p class="mt-5 text-[17px] leading-[1.6] text-white/65">Nous recherchons des profils rigoureux, autonomes et orientés terrain pour construire des projets à impact.</p>
            </div>
            <div class="relative mt-12">
                <a href="{{ route('public.carrieres.index') }}" class="btn btn-light">Voir les offres</a>
            </div>
        </div>

        <form method="POST" action="{{ route('public.home.contact') }}" class="tile p-8 md:p-12" data-reveal style="--reveal-delay: 90ms">
            @csrf
            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
            <p class="eyebrow">Contact rapide</p>
            <h2 class="title mt-1">Une question ? Écrivez-nous.</h2>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div>
                    <label for="home-nom" class="field-label">Nom complet</label>
                    <input id="home-nom" name="nom" required value="{{ old('nom') }}" autocomplete="name" class="field">
                </div>
                <div>
                    <label for="home-email" class="field-label">Email</label>
                    <input id="home-email" name="email" required type="email" value="{{ old('email') }}" autocomplete="email" class="field">
                </div>
                <div>
                    <label for="home-sujet" class="field-label">Sujet</label>
                    <input id="home-sujet" name="sujet" required value="{{ old('sujet') }}" class="field">
                </div>
                <div>
                    <label for="home-type" class="field-label">Type de demande</label>
                    <select id="home-type" name="type_demande" required class="field">
                        @foreach (['Commercial', 'Partenariat', 'Recrutement', 'Média', 'Support'] as $type)
                            <option @selected(old('type_demande') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="home-message" class="field-label">Message</label>
                    <textarea id="home-message" name="message" required rows="4" class="field resize-none">{{ old('message') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button class="btn btn-primary w-full md:w-auto">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
