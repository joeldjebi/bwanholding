@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="BWAN TV" title="Vidéos, interviews et contenus institutionnels." tone="dark">
    <x-slot:back>
        <a href="{{ route('public.medias.index') }}" class="back-link !text-[#6fd3b0]">Médias</a>
    </x-slot:back>
</x-page-hero>

<section class="bg-night pb-20 text-white md:pb-28">
    <div class="wrap">
        <div class="grid gap-x-6 gap-y-14 md:grid-cols-2">
            @forelse ($videos as $i => $video)
                <article @class(['md:col-span-2' => $i === 0 && $videos->onFirstPage()]) data-reveal style="--reveal-delay: {{ ($i % 2) * 90 }}ms">
                    <div class="aspect-video overflow-hidden rounded-[24px] bg-white/5 ring-1 ring-white/10">
                        @if ($video->url_embed)
                            <iframe src="{{ $video->url_embed }}" title="{{ $video->titre }}" class="h-full w-full" loading="lazy" allowfullscreen></iframe>
                        @endif
                    </div>
                    <div class="mt-6 max-w-2xl">
                        <p class="text-[13px] font-medium text-white/50">{{ $video->date?->locale('fr')->translatedFormat('j F Y') }}</p>
                        <h2 @class(['mt-1 font-semibold tracking-tight', 'text-[28px] md:text-[36px] leading-[1.1]' => $i === 0 && $videos->onFirstPage(), 'text-[21px] leading-tight' => ! ($i === 0 && $videos->onFirstPage())])>{{ $video->titre }}</h2>
                        @if ($video->description)
                            <p class="mt-3 text-[17px] leading-[1.55] text-white/60">{{ $video->description }}</p>
                        @endif
                    </div>
                </article>
            @empty
                <p class="rounded-[28px] bg-white/5 p-12 text-center text-white/60 md:col-span-2">Aucune vidéo publiée pour le moment.</p>
            @endforelse
        </div>
        <div class="mt-14 [&_a]:!text-white [&_a:hover]:!bg-white/10 [&_span[aria-current]]:!bg-white [&_span[aria-current]]:!text-ink">{{ $videos->links() }}</div>
    </div>
</section>
@endsection
