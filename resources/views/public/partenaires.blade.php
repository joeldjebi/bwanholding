@extends('layouts.public')

@section('content')
@php use App\Support\MediaUrl; @endphp

<x-page-hero
    eyebrow="Écosystème"
    title="Des partenaires pour accélérer l’exécution."
    lead="BWAN HOLDING développe un écosystème de partenaires techniques, institutionnels et commerciaux pour renforcer l’impact de ses projets."
/>

<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-16 md:gap-20">
        @forelse ($partenaires as $categorie => $items)
            <section data-reveal>
                <div class="flex items-baseline justify-between gap-4 border-b border-black/[.08] pb-4">
                    <h2 class="title capitalize">{{ $categorie }}</h2>
                    <span class="meta">{{ $items->count() }} partenaire{{ $items->count() > 1 ? 's' : '' }}</span>
                </div>
                <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5">
                    @foreach ($items as $partenaire)
                        <div class="group flex min-h-36 flex-col items-center justify-center gap-3 rounded-[20px] bg-surface p-6 text-center transition duration-500 hover:bg-white hover:shadow-[0_12px_32px_rgba(0,0,0,.08)]">
                            @if ($partenaire->logo)
                                <img loading="lazy" src="{{ MediaUrl::for($partenaire->logo) }}" alt="Logo {{ $partenaire->nom }}" class="max-h-14 max-w-full object-contain opacity-80 grayscale transition duration-500 group-hover:opacity-100 group-hover:grayscale-0">
                            @else
                                <span class="text-[15px] font-medium text-ink">{{ $partenaire->nom }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @empty
            <p class="tile p-12 text-center text-muted">Les partenaires seront publiés prochainement.</p>
        @endforelse
    </div>
</section>

<section class="pb-20 md:pb-28">
    <div class="wrap">
        <div class="tile-dark px-8 py-16 text-center md:py-20" data-reveal>
            <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -bottom-32 mx-auto h-72 max-w-2xl rounded-full bg-[radial-gradient(closest-side,rgba(111,211,176,.25),transparent)] blur-2xl"></div>
            <p class="eyebrow relative !text-[#6fd3b0]">Devenir partenaire</p>
            <h2 class="headline relative mx-auto mt-2 max-w-2xl">Construisons ensemble des projets à impact.</h2>
            <div class="relative mt-10">
                <a href="{{ route('public.contact.index') }}" class="btn btn-light">Proposer un partenariat</a>
            </div>
        </div>
    </div>
</section>
@endsection
