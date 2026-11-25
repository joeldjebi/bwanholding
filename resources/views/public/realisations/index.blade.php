@extends('layouts.public')

@section('content')
@php use App\Support\MediaUrl; @endphp

<x-page-hero
    eyebrow="Réalisations"
    title="Des projets livrés avec une logique de preuve."
    lead="Chaque mission documente une problématique, une solution et un résultat. Retrouvez les opérations récentes portées par le groupe et ses entités."
/>

<section class="pb-20 md:pb-28">
    <div class="wrap">
        @if ($secteurs->isNotEmpty())
            <nav aria-label="Filtrer par secteur" class="-mx-5 flex gap-2 overflow-x-auto px-5 pb-2 md:mx-0 md:flex-wrap md:justify-center md:px-0" data-reveal>
                <a href="{{ route('public.realisations.index') }}" @class(['shrink-0 rounded-full px-4 py-2 text-[14px] transition', 'bg-ink text-white' => ! $selectedSecteur, 'bg-surface text-ink hover:bg-black/[.08]' => $selectedSecteur])>Tous les secteurs</a>
                @foreach ($secteurs->filter() as $secteur)
                    <a href="{{ route('public.realisations.index', ['secteur' => $secteur]) }}" @class(['shrink-0 rounded-full px-4 py-2 text-[14px] transition', 'bg-ink text-white' => $selectedSecteur === $secteur, 'bg-surface text-ink hover:bg-black/[.08]' => $selectedSecteur !== $secteur])>{{ $secteur }}</a>
                @endforeach
            </nav>
        @endif

        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($realisations as $i => $realisation)
                @php $image = ($realisation->images[0] ?? null); @endphp
                <a href="{{ route('public.realisations.show', $realisation) }}" class="card media-zoom group flex flex-col" data-reveal style="--reveal-delay: {{ ($i % 3) * 90 }}ms">
                    <div class="relative aspect-[4/3] overflow-hidden bg-surface">
                        @if ($image)
                            <img loading="lazy" src="{{ MediaUrl::for($image) }}" alt="{{ $realisation->titre }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-[15px] font-medium text-subtle">BWAN HOLDING</div>
                        @endif
                        @if ($realisation->secteur)
                            <span class="chip absolute top-4 left-4">{{ $realisation->secteur }}</span>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-7">
                        <h2 class="text-[21px] leading-tight font-semibold tracking-tight">{{ $realisation->titre }}</h2>
                        <p class="mt-3 flex-1 text-[15px] leading-[1.55] text-muted">{{ str($realisation->resultat ?: $realisation->solution)->limit(150) }}</p>
                        <span class="link-more mt-5 text-[15px]">Voir le cas</span>
                    </div>
                </a>
            @empty
                <p class="tile p-12 text-center text-muted md:col-span-2 lg:col-span-3">Aucune réalisation publiée pour le moment.</p>
            @endforelse
        </div>
        <div class="mt-14">{{ $realisations->links() }}</div>
    </div>
</section>
@endsection
