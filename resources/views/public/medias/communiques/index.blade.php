@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="Communiqués" title="Annonces officielles.">
    <x-slot:back>
        <a href="{{ route('public.medias.index') }}" class="back-link">Médias</a>
    </x-slot:back>
</x-page-hero>

<section class="pb-20 md:pb-28">
    <div class="wrap max-w-[880px]">
        <div class="overflow-hidden rounded-[28px] bg-surface" data-reveal>
            @forelse ($articles as $article)
                <a href="{{ route('public.medias.communiques.show', $article) }}" class="group flex items-center justify-between gap-6 border-b border-black/[.06] px-7 py-7 transition-colors last:border-0 hover:bg-black/[.03] md:px-10">
                    <div>
                        <p class="meta">{{ $article->date_publication?->locale('fr')->translatedFormat('j F Y') }}</p>
                        <h2 class="mt-1 text-[19px] leading-snug font-semibold tracking-tight md:text-[21px]">{{ $article->titre }}</h2>
                    </div>
                    <span aria-hidden="true" class="text-2xl text-subtle transition duration-300 group-hover:translate-x-1 group-hover:text-brand">&rsaquo;</span>
                </a>
            @empty
                <p class="p-12 text-center text-muted">Aucun communiqué publié.</p>
            @endforelse
        </div>
        <div class="mt-14">{{ $articles->links() }}</div>
    </div>
</section>
@endsection
