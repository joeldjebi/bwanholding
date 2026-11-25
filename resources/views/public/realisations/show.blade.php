@extends('layouts.public')

@section('content')
@php
    use App\Support\MediaUrl;

    $cover = $realisation->images[0] ?? null;
@endphp

<x-page-hero
    :eyebrow="$realisation->secteur"
    :title="$realisation->titre"
    :lead="str($realisation->resultat ?: $realisation->solution)->limit(220)"
>
    <x-slot:back>
        <a href="{{ route('public.realisations.index') }}" class="back-link">Toutes les réalisations</a>
    </x-slot:back>
</x-page-hero>

<section class="pb-20 md:pb-28">
    <div class="wrap-wide" data-reveal>
        <div class="overflow-hidden rounded-[28px] bg-surface md:rounded-[40px]">
            @if ($cover)
                <img src="{{ MediaUrl::for($cover) }}" alt="{{ $realisation->titre }}" class="aspect-[4/3] w-full object-cover md:aspect-[16/9]" fetchpriority="high">
            @else
                <div class="flex aspect-[16/9] items-center justify-center text-[17px] font-medium text-subtle">BWAN HOLDING</div>
            @endif
        </div>
    </div>
</section>

<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-5 md:grid-cols-3">
        @foreach ([['Problématique', $realisation->problematique, '01'], ['Solution', $realisation->solution, '02'], ['Résultat', $realisation->resultat, '03']] as $i => [$label, $text, $num])
            <article @class(['p-9 md:p-10', 'tile' => $i < 2, 'tile-dark' => $i === 2]) data-reveal style="--reveal-delay: {{ $i * 90 }}ms">
                <p @class(['text-[13px] font-medium', 'text-subtle' => $i < 2, 'text-white/50' => $i === 2])>{{ $num }}</p>
                <h2 class="title mt-1">{{ $label }}</h2>
                <p @class(['mt-4 text-[17px] leading-[1.6]', 'text-muted' => $i < 2, 'text-white/75' => $i === 2])>{{ $text }}</p>
            </article>
        @endforeach
    </div>
</section>

@if (count($realisation->images ?? []) > 1)
    <section class="bg-surface py-20 md:py-28">
        <div class="wrap">
            <x-section-heading eyebrow="Galerie" title="Images du projet." />
            <div class="mt-14 grid gap-4 md:grid-cols-2">
                @foreach ($realisation->images as $i => $image)
                    <div @class(['media-zoom overflow-hidden rounded-[24px] bg-white', 'md:col-span-2' => $i % 3 === 0]) data-reveal>
                        <img loading="lazy" src="{{ MediaUrl::for($image) }}" alt="Image de la réalisation {{ $realisation->titre }}" @class(['w-full object-cover', 'aspect-[16/9]' => $i % 3 === 0, 'aspect-[4/3]' => $i % 3 !== 0])>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if ($realisation->video_url)
    <section class="section">
        <div class="wrap">
            <x-section-heading eyebrow="Vidéo" title="Le projet en images." />
            <div class="mt-12 aspect-video overflow-hidden rounded-[28px] bg-night shadow-[0_40px_80px_-30px_rgba(0,0,0,.35)]" data-reveal>
                <iframe src="{{ $realisation->video_url }}" title="Vidéo {{ $realisation->titre }}" class="h-full w-full" loading="lazy" allowfullscreen></iframe>
            </div>
        </div>
    </section>
@endif

<section class="pb-20 md:pb-28">
    <div class="wrap">
        <div class="tile-dark px-8 py-16 text-center md:py-20" data-reveal>
            <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -bottom-32 mx-auto h-72 max-w-2xl rounded-full bg-[radial-gradient(closest-side,rgba(111,211,176,.25),transparent)] blur-2xl"></div>
            <p class="eyebrow relative !text-[#6fd3b0]">Projet similaire</p>
            <h2 class="headline relative mt-2">Vous souhaitez cadrer une mission ?</h2>
            <div class="relative mt-10">
                <a href="{{ route('public.contact.index') }}" class="btn btn-light">Contacter BWAN HOLDING</a>
            </div>
        </div>
    </div>
</section>
@endsection
