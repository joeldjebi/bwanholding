@extends('layouts.public')

@section('content')
@php use App\Support\MediaUrl; @endphp

<x-page-hero
    :eyebrow="collect([$entreprise->domaine?->nom, $entreprise->statut ? ucfirst($entreprise->statut) : null])->filter()->join(' · ')"
    :title="$entreprise->nom"
    :lead="$entreprise->description"
>
    <x-slot:back>
        <a href="{{ route('public.entreprises.index') }}" class="back-link">Toutes les entités</a>
    </x-slot:back>
    <a href="{{ route('public.contact.index') }}" class="btn btn-primary">Contacter cette entité</a>
</x-page-hero>

<section class="pb-20 md:pb-28">
    <div class="wrap">
        <div class="tile flex min-h-[320px] items-center justify-center p-12 md:min-h-[440px]" data-reveal>
            @if ($entreprise->logo)
                <img src="{{ MediaUrl::for($entreprise->logo) }}" alt="Logo {{ $entreprise->nom }}" class="max-h-40 max-w-[60%] object-contain md:max-h-52">
            @else
                <span class="text-[56px] font-semibold tracking-tight text-ink md:text-[88px]">{{ $entreprise->nom }}</span>
            @endif
        </div>
    </div>
</section>

<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-5 lg:grid-cols-[1.4fr_.6fr]">
        <div class="card p-9 md:p-12" data-reveal>
            <p class="eyebrow">Services</p>
            <h2 class="title mt-1">Ce que nous proposons.</h2>
            <ul class="mt-8 grid gap-x-8 md:grid-cols-2">
                @forelse (($entreprise->services ?: []) as $service)
                    <li class="flex items-start gap-3 border-t border-black/[.08] py-4 text-[17px]">
                        <span class="mt-0.5 text-[13px] text-brand">✓</span>
                        {{ $service }}
                    </li>
                @empty
                    <li class="text-[17px] text-muted">Les services seront détaillés prochainement.</li>
                @endforelse
            </ul>
        </div>
        <aside class="tile-dark flex flex-col justify-between p-9 md:p-10" data-reveal style="--reveal-delay: 120ms">
            <div>
                <p class="eyebrow !text-[#6fd3b0]">Cible</p>
                <p class="mt-4 text-[19px] leading-[1.55] text-white/80">{{ $entreprise->cible ?: 'Entreprises, institutions et particuliers selon les offres.' }}</p>
            </div>
            <a href="{{ route('public.contact.index') }}" class="btn btn-light mt-10 self-start">Prendre contact</a>
        </aside>
    </div>
</section>
@endsection
