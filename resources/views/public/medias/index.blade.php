@extends('layouts.public')

@section('content')
<x-page-hero
    eyebrow="Médias"
    title="L’actualité, les images et les contenus du groupe."
    lead="Retrouvez les publications officielles, les communiqués, les vidéos et les albums photo de BWAN HOLDING."
/>

<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-5 md:grid-cols-2">
        @foreach ([
            ['Actualités', 'Les nouvelles du groupe, de ses pôles et de ses entités.', 'public.medias.actualites.index', '✦', true],
            ['BWAN TV', 'Vidéos, interviews et contenus institutionnels.', 'public.medias.bwan-tv', '▶', true],
            ['Photothèque', 'Albums et images terrain.', 'public.medias.phototheque', '◎', false],
            ['Communiqués', 'Annonces officielles.', 'public.medias.communiques.index', '◈', false],
        ] as $i => [$label, $text, $route, $icon, $dark])
            <a
                href="{{ route($route) }}"
                @class(['group flex min-h-[300px] flex-col justify-between p-9 transition duration-500 md:min-h-[380px] md:p-12', 'tile-dark' => $dark, 'tile' => ! $dark])
                data-reveal
                style="--reveal-delay: {{ ($i % 2) * 90 }}ms"
            >
                @if ($dark)
                    <div aria-hidden="true" class="pointer-events-none absolute -right-20 -bottom-20 h-72 w-72 rounded-full bg-[radial-gradient(closest-side,rgba(111,211,176,.28),transparent)] blur-2xl transition duration-700 group-hover:scale-125"></div>
                @endif
                <div @class(['relative flex h-14 w-14 items-center justify-center rounded-full text-xl', 'bg-white/10 text-[#e6c27a]' => $dark, 'bg-white text-brand shadow-sm' => ! $dark])>{{ $icon }}</div>
                <div class="relative mt-12">
                    <h2 class="text-[32px] leading-[1.05] font-semibold tracking-[-0.025em] md:text-[44px]">{{ $label }}</h2>
                    <p @class(['mt-3 text-[17px] leading-[1.55]', 'text-white/65' => $dark, 'text-muted' => ! $dark])>{{ $text }}</p>
                    <span @class(['link-more mt-6', 'link-more-light' => $dark])>Explorer</span>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
