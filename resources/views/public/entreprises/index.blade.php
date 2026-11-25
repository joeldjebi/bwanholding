@extends('layouts.public')

@section('content')
@php use App\Support\MediaUrl; @endphp

<x-page-hero
    eyebrow="Portefeuille"
    title="Entreprises & Startups"
    lead="Découvrez les filiales, marques et startups opérées par BWAN HOLDING dans ses différents domaines d’activité."
/>

<section class="pb-20 md:pb-28">
    <div class="wrap">
        {{-- Filtres en pastilles --}}
        <nav aria-label="Filtrer par domaine" class="-mx-5 flex gap-2 overflow-x-auto px-5 pb-2 md:mx-0 md:flex-wrap md:justify-center md:px-0" data-reveal>
            <a href="{{ route('public.entreprises.index') }}" @class(['shrink-0 rounded-full px-4 py-2 text-[14px] transition', 'bg-ink text-white' => ! $selectedDomaine, 'bg-surface text-ink hover:bg-black/[.08]' => $selectedDomaine])>Tous</a>
            @foreach ($domaines as $domaine)
                <a href="{{ route('public.entreprises.index', ['domaine' => $domaine->slug]) }}" @class(['shrink-0 rounded-full px-4 py-2 text-[14px] transition', 'bg-ink text-white' => $selectedDomaine === $domaine->slug, 'bg-surface text-ink hover:bg-black/[.08]' => $selectedDomaine !== $domaine->slug])>{{ $domaine->nom }}</a>
            @endforeach
        </nav>

        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($entreprises as $i => $entreprise)
                <a href="{{ route('public.entreprises.show', $entreprise) }}" class="card group flex flex-col" data-reveal style="--reveal-delay: {{ ($i % 3) * 90 }}ms">
                    <div class="flex h-48 items-center justify-center bg-surface p-10">
                        @if ($entreprise->logo)
                            <img loading="lazy" src="{{ MediaUrl::for($entreprise->logo) }}" alt="Logo {{ $entreprise->nom }}" class="max-h-24 max-w-[70%] object-contain transition duration-700 group-hover:scale-105">
                        @else
                            <span class="flex h-20 w-20 items-center justify-center rounded-3xl bg-white text-3xl font-semibold text-brand shadow-sm">{{ mb_substr($entreprise->nom, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-8">
                        <p class="meta">{{ $entreprise->domaine?->nom }}</p>
                        <h2 class="title mt-1">{{ $entreprise->nom }}</h2>
                        <p class="mt-3 flex-1 text-[15px] leading-[1.55] text-muted">{{ str($entreprise->description)->limit(150) }}</p>
                        <span class="link-more mt-6 text-[15px]">Découvrir</span>
                    </div>
                </a>
            @empty
                <p class="tile p-12 text-center text-muted md:col-span-2 lg:col-span-3">Aucune entité publiée pour le moment.</p>
            @endforelse
        </div>
        <div class="mt-14">{{ $entreprises->links() }}</div>
    </div>
</section>
@endsection
