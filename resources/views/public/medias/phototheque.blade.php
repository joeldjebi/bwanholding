@extends('layouts.public')

@section('content')
@php
    use App\Support\MediaUrl;

    $carouselPhotos = $albums
        ->getCollection()
        ->flatMap(fn ($album) => $album->photos->map(fn ($photo) => [
            'src' => MediaUrl::for($photo->url),
            'alt' => $photo->legende ?: $album->titre,
            'album' => $album->titre,
            'date' => $album->date?->format('d/m/Y'),
        ]))
        ->values();
@endphp

<div
    x-data="{
        open: false,
        index: 0,
        photos: @js($carouselPhotos),
        show(i) { this.index = i; this.open = true; document.body.classList.add('overflow-hidden') },
        close() { this.open = false; document.body.classList.remove('overflow-hidden') },
        next() { this.index = (this.index + 1) % this.photos.length },
        prev() { this.index = (this.index - 1 + this.photos.length) % this.photos.length },
    }"
    x-on:keydown.escape.window="close()"
    x-on:keydown.arrow-right.window="open && next()"
    x-on:keydown.arrow-left.window="open && prev()"
>
    <x-page-hero
        eyebrow="Photothèque"
        title="Albums photo"
        lead="Une sélection d’images issues des opérations, évènements et moments institutionnels du groupe."
    >
        <x-slot:back>
            <a href="{{ route('public.medias.index') }}" class="back-link">Médias</a>
        </x-slot:back>
    </x-page-hero>

    <section class="pb-20 md:pb-28">
        <div class="wrap">
            @if ($categories->isNotEmpty())
                <nav aria-label="Filtrer par catégorie" class="-mx-5 flex gap-2 overflow-x-auto px-5 pb-2 md:mx-0 md:flex-wrap md:justify-center md:px-0" data-reveal>
                    <a href="{{ route('public.medias.phototheque') }}" @class(['shrink-0 rounded-full px-4 py-2 text-[14px] transition', 'bg-ink text-white' => ! request('categorie'), 'bg-surface text-ink hover:bg-black/[.08]' => request('categorie')])>Toutes</a>
                    @foreach ($categories as $categorie)
                        <a href="{{ route('public.medias.phototheque', ['categorie' => $categorie]) }}" @class(['shrink-0 rounded-full px-4 py-2 text-[14px] transition', 'bg-ink text-white' => request('categorie') === $categorie, 'bg-surface text-ink hover:bg-black/[.08]' => request('categorie') !== $categorie])>{{ $categorie }}</a>
                    @endforeach
                </nav>
            @endif

            <div class="mt-12 grid gap-x-5 gap-y-12 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($albums as $i => $album)
                    <article data-reveal style="--reveal-delay: {{ ($i % 3) * 90 }}ms">
                        <div class="grid grid-cols-2 gap-1.5 overflow-hidden rounded-[24px]">
                            @foreach ($album->photos->take(4) as $p => $photo)
                                @php
                                    $photoIndex = $carouselPhotos->search(fn ($item) => $item['src'] === MediaUrl::for($photo->url) && $item['alt'] === ($photo->legende ?: $album->titre));
                                @endphp
                                <button
                                    type="button"
                                    @class(['media-zoom overflow-hidden bg-surface', 'col-span-2' => $album->photos->count() === 1 || ($p === 0 && $album->photos->count() === 3)])
                                    @click="show({{ $photoIndex === false ? 0 : $photoIndex }})"
                                    aria-label="Agrandir {{ $photo->legende ?: $album->titre }}"
                                >
                                    <img loading="lazy" src="{{ MediaUrl::for($photo->url) }}" alt="{{ $photo->legende ?: $album->titre }}" @class(['w-full object-cover', 'aspect-square' => ! ($album->photos->count() === 1 || ($p === 0 && $album->photos->count() === 3)), 'aspect-[2/1]' => $album->photos->count() === 1 || ($p === 0 && $album->photos->count() === 3)])>
                                </button>
                            @endforeach
                        </div>
                        <p class="meta mt-5">{{ collect([$album->categorie, $album->date?->format('d/m/Y')])->filter()->join(' · ') }}</p>
                        <h2 class="mt-1 text-[21px] leading-tight font-semibold tracking-tight">{{ $album->titre }}</h2>
                        <p class="mt-1 text-[14px] text-subtle">{{ $album->photos->count() }} photo(s)</p>
                    </article>
                @empty
                    <p class="tile p-12 text-center text-muted md:col-span-2 lg:col-span-3">Aucun album publié pour le moment.</p>
                @endforelse
            </div>
            <div class="mt-14">{{ $albums->links() }}</div>
        </div>
    </section>

    {{-- Visionneuse --}}
    <div
        x-show="open"
        x-cloak
        x-transition.opacity.duration.300ms
        class="fixed inset-0 z-[60] bg-black/95 text-white backdrop-blur-xl"
        role="dialog"
        aria-modal="true"
        aria-label="Visionneuse photo"
    >
        <div class="flex h-full flex-col px-4 pb-4">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 py-4">
                <div>
                    <p class="text-[15px] font-semibold" x-text="photos[index]?.album"></p>
                    <p class="text-[13px] text-white/50" x-text="photos[index]?.date"></p>
                </div>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-lg transition hover:bg-white/20" @click="close()" aria-label="Fermer">✕</button>
            </div>
            <div class="relative mx-auto flex min-h-0 w-full max-w-7xl flex-1 items-center justify-center">
                <button type="button" class="absolute left-0 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-3xl backdrop-blur transition hover:bg-white/20" @click="prev()" aria-label="Image précédente">&lsaquo;</button>
                <img :src="photos[index]?.src" :alt="photos[index]?.alt" class="max-h-full max-w-full rounded-2xl object-contain">
                <button type="button" class="absolute right-0 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-3xl backdrop-blur transition hover:bg-white/20" @click="next()" aria-label="Image suivante">&rsaquo;</button>
            </div>
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 pt-4 text-[14px] text-white/60">
                <p x-text="photos[index]?.alt"></p>
                <p class="tabular-nums"><span x-text="index + 1"></span> / <span x-text="photos.length"></span></p>
            </div>
        </div>
    </div>
</div>
@endsection
