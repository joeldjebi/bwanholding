@extends('layouts.public')

@section('content')
@php
    use App\Support\MediaUrl;

    $isCommunique = request()->routeIs('public.medias.communiques.*');
@endphp

<article>
    <header class="wrap max-w-[820px] pt-16 pb-12 text-center md:pt-24 md:pb-16">
        <div class="hero-fade">
            <a href="{{ $isCommunique ? route('public.medias.communiques.index') : route('public.medias.actualites.index') }}" class="back-link">{{ $isCommunique ? 'Communiqués' : 'Actualités' }}</a>
            <p class="meta mt-8">{{ $article->date_publication?->locale('fr')->translatedFormat('j F Y') }}</p>
            <h1 class="mt-3 text-[36px] leading-[1.08] font-semibold tracking-[-0.03em] text-balance md:text-[56px]">{{ $article->titre }}</h1>
        </div>
    </header>

    @if ($article->image)
        <div class="wrap-wide pb-14 md:pb-20" data-reveal>
            <img src="{{ MediaUrl::for($article->image) }}" alt="{{ $article->titre }}" class="aspect-[16/9] w-full rounded-[28px] object-cover md:rounded-[40px]" fetchpriority="high">
        </div>
    @endif

    <div class="wrap max-w-[720px] pb-20 md:pb-28">
        <div class="prose-apple" data-reveal>{!! nl2br(e($article->contenu)) !!}</div>
        <div class="divider mt-16"></div>
        <div class="mt-8 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ $isCommunique ? route('public.medias.communiques.index') : route('public.medias.actualites.index') }}" class="back-link">Tous les {{ $isCommunique ? 'communiqués' : 'articles' }}</a>
            <a href="{{ route('public.contact.index') }}" class="link-more text-[15px]">Contact presse</a>
        </div>
    </div>
</article>
@endsection
