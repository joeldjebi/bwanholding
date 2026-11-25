@extends('layouts.public')

@section('content')
@php use App\Support\MediaUrl; @endphp

<x-page-hero eyebrow="Actualités" title="Les nouvelles du groupe.">
    <x-slot:back>
        <a href="{{ route('public.medias.index') }}" class="back-link">Médias</a>
    </x-slot:back>
</x-page-hero>

<section class="pb-20 md:pb-28">
    <div class="wrap">
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $i => $article)
                <a
                    href="{{ route('public.medias.actualites.show', $article) }}"
                    @class(['card media-zoom group flex flex-col', 'md:col-span-2 lg:col-span-3 lg:grid lg:grid-cols-[1.3fr_1fr]' => $i === 0 && $articles->onFirstPage()])
                    data-reveal
                    style="--reveal-delay: {{ ($i % 3) * 90 }}ms"
                >
                    <div @class(['overflow-hidden bg-surface', 'aspect-[16/10]' => ! ($i === 0 && $articles->onFirstPage()), 'aspect-[16/10] lg:aspect-auto lg:min-h-[420px]' => $i === 0 && $articles->onFirstPage()])>
                        @if ($article->image)
                            <img loading="lazy" src="{{ MediaUrl::for($article->image) }}" alt="{{ $article->titre }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-brand-soft to-surface text-[15px] font-medium text-brand">BWAN HOLDING</div>
                        @endif
                    </div>
                    <div @class(['flex flex-1 flex-col p-7', 'lg:justify-center lg:p-12' => $i === 0 && $articles->onFirstPage()])>
                        <p class="meta">{{ $article->date_publication?->locale('fr')->translatedFormat('j F Y') }}</p>
                        <h2 @class(['mt-2 font-semibold tracking-tight', 'text-[21px] leading-tight' => ! ($i === 0 && $articles->onFirstPage()), 'text-[28px] leading-[1.1] md:text-[40px]' => $i === 0 && $articles->onFirstPage()])>{{ $article->titre }}</h2>
                        <span class="link-more mt-6 text-[15px]">Lire l’article</span>
                    </div>
                </a>
            @empty
                <p class="tile p-12 text-center text-muted md:col-span-2 lg:col-span-3">Aucune actualité publiée.</p>
            @endforelse
        </div>
        <div class="mt-14">{{ $articles->links() }}</div>
    </div>
</section>
@endsection
