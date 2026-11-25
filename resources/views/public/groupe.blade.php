@extends('layouts.public')

@section('content')
<x-page-hero
    eyebrow="Le Groupe"
    title="Une holding opérationnelle au service des ambitions africaines."
    lead="BWAN HOLDING accompagne la création, l’exploitation et le développement d’entreprises capables de servir les marchés africains avec exigence, proximité et innovation."
>
    <a href="{{ route('public.domaines.index') }}" class="btn btn-primary">Voir les pôles</a>
    <a href="#president" class="link-more">Le mot du Président</a>
</x-page-hero>

{{-- POSTURE --}}
<section class="pb-20 md:pb-28">
    <div class="wrap">
        <div class="tile-dark px-8 py-16 text-center md:px-16 md:py-24" data-reveal>
            <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -top-32 mx-auto h-72 max-w-2xl rounded-full bg-[radial-gradient(closest-side,rgba(111,211,176,.25),transparent)] blur-2xl"></div>
            <p class="eyebrow relative !text-[#6fd3b0]">Notre posture</p>
            <p class="relative mx-auto mt-4 max-w-3xl text-[30px] leading-[1.15] font-semibold tracking-[-0.025em] md:text-[52px]">
                Investir dans des métiers utiles, puis les <span class="gradient-text-light">opérer avec méthode.</span>
            </p>
        </div>
    </div>
</section>

{{-- MOT DU PRÉSIDENT --}}
<section id="president" class="scroll-mt-20 bg-surface py-20 md:py-28">
    <div class="wrap grid items-center gap-12 md:grid-cols-[.85fr_1.15fr] md:gap-16">
        <div class="overflow-hidden rounded-[28px] bg-white shadow-[0_30px_60px_-20px_rgba(0,0,0,.25)]" data-reveal>
            <img src="{{ asset('assets/images/germ.jpeg') }}" alt="Germe Kouakou De Janvier KOUAKOU, Président de BWAN HOLDING" class="aspect-[4/5] w-full object-cover object-top">
        </div>
        <div data-reveal style="--reveal-delay: 120ms">
            <p class="eyebrow">Le mot du Président</p>
            <h2 class="headline mt-2">Bienvenue chez BWAN HOLDING.</h2>
            <blockquote class="mt-8 grid gap-5 text-[19px] leading-[1.6] text-ink/80 md:text-[21px]">
                <p>« Lorsque nous avons fondé ce groupe, nous portions une conviction simple : l'Afrique n'a pas besoin qu'on lui apporte des solutions venues d'ailleurs, elle a besoin qu'on conçoive, sur son sol et avec ses talents, des solutions utiles, accessibles et durables.</p>
                <p>C'est cette conviction qui guide chacune de nos décisions. »</p>
            </blockquote>
            <div class="mt-8">
                <p class="text-[17px] font-semibold">Germe Kouakou De Janvier KOUAKOU</p>
                <p class="text-[15px] text-muted">Président, BWAN HOLDING</p>
            </div>
        </div>
    </div>
</section>

{{-- VISION / MISSION / VALEURS --}}
<section class="section">
    <div class="wrap">
        <x-section-heading eyebrow="Ce qui nous guide" title="Vision, mission, valeurs." />
        <div class="mt-14 grid gap-5 md:grid-cols-3">
            @foreach ([
                ['Vision', 'Devenir une référence africaine de l’investissement opérationnel multisectoriel.', '◎'],
                ['Mission', 'Créer, relier et accélérer des entreprises utiles aux économies locales.', '◈'],
                ['Valeurs', 'Intégrité, excellence, audace, transmission et responsabilité.', '✦'],
            ] as $i => [$label, $text, $icon])
                <article class="tile p-9 md:p-10" data-reveal style="--reveal-delay: {{ $i * 90 }}ms">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-xl text-brand shadow-sm">{{ $icon }}</div>
                    <h3 class="title mt-8">{{ $label }}</h3>
                    <p class="mt-3 text-[17px] leading-[1.55] text-muted">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- HISTORIQUE --}}
<section class="bg-surface py-20 md:py-28">
    <div class="wrap">
        <x-section-heading eyebrow="Historique" title="Une construction progressive, pensée pour durer." />
        <ol class="relative mx-auto mt-16 max-w-3xl">
            <span aria-hidden="true" class="absolute top-2 bottom-2 left-[7px] w-px bg-black/10 md:left-1/2"></span>
            @foreach ([
                ['2019', 'Premières initiatives entrepreneuriales et structuration d’une vision multisectorielle.'],
                ['2021', 'Organisation des pôles métiers et premiers partenariats opérationnels.'],
                ['2024', 'Accélération des filiales, consolidation de l’écosystème et montée en qualité.'],
                ['2026', 'Institutionnalisation de BWAN HOLDING et développement du portefeuille.'],
            ] as $i => [$year, $text])
                <li class="relative grid gap-2 pb-12 pl-10 last:pb-0 md:grid-cols-2 md:gap-16 md:pl-0" data-reveal>
                    <span aria-hidden="true" class="absolute top-2 left-0 h-[15px] w-[15px] rounded-full border-[3px] border-surface bg-brand md:left-1/2 md:-translate-x-1/2"></span>
                    <p @class(['text-[40px] leading-none font-semibold tracking-[-0.03em] md:text-[56px]', 'md:text-right' => $i % 2 === 0, 'md:order-2' => $i % 2 === 1])>
                        <span class="gradient-text">{{ $year }}</span>
                    </p>
                    <p @class(['text-[17px] leading-[1.6] text-muted md:pt-2', 'md:order-1 md:text-right' => $i % 2 === 1])>{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- GOUVERNANCE --}}
<section class="section">
    <div class="wrap grid items-center gap-12 md:grid-cols-[1.1fr_.9fr] md:gap-16">
        <div data-reveal>
            <p class="eyebrow">Gouvernance</p>
            <h2 class="headline mt-2">Un pilotage clair entre stratégie, exécution et contrôle.</h2>
            <p class="lead mt-6">Le comité de direction pilote la stratégie, l’allocation des ressources et la cohérence opérationnelle des filiales. Le mot du dirigeant incarne une conviction simple : bâtir des entreprises solides, utiles et transmissibles.</p>
        </div>
        <div class="tile p-8 md:p-10" data-reveal style="--reveal-delay: 120ms">
            <p class="meta">Organigramme</p>
            <ol class="mt-6 grid gap-3">
                @foreach (['Présidence', 'Direction générale', 'Directions de pôles', 'Responsables d’entités'] as $i => $level)
                    <li class="flex items-center gap-4 rounded-2xl bg-white px-5 py-4 shadow-[0_1px_2px_rgba(0,0,0,.04)]" style="margin-left: {{ $i * 16 }}px">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand text-[13px] font-semibold text-white">{{ $i + 1 }}</span>
                        <span class="text-[17px] font-medium">{{ $level }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
@endsection
