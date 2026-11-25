@extends('layouts.public')

@section('content')
@php
    $coordonnees = [
        ['Adresse', $settings['adresse'] ?? 'Siège BWAN HOLDING, Afrique de l’Ouest', '⌂'],
        ['Téléphone', $settings['telephone'] ?? 'Fixe : 27 33 71 29 14 · Mobile : 07 78 78 06 06 / 05 56 28 28 76', '✆'],
        ['Email', $settings['email'] ?? 'infos@bwanholding.com · Rh@bwanholding.com · bwanholding@gmail.com', '✉'],
    ];
    $reseaux = array_filter([
        'LinkedIn' => $settings['linkedin'] ?? null,
        'Facebook' => $settings['facebook'] ?? null,
        'Instagram' => $settings['instagram'] ?? null,
    ]);
@endphp

<x-page-hero
    eyebrow="Contact"
    title="Parlons de votre besoin."
    lead="Commercial, partenariat, recrutement, média ou support : votre demande sera orientée vers la bonne équipe."
/>

<section class="pb-20 md:pb-28">
    <div class="wrap grid gap-5 lg:grid-cols-[.85fr_1.15fr]">
        <div class="grid content-start gap-5">
            <div class="tile p-8 md:p-10" data-reveal>
                <ul class="grid gap-7">
                    @foreach ($coordonnees as [$label, $value, $icon])
                        <li class="flex gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-brand shadow-sm">{{ $icon }}</span>
                            <div>
                                <p class="meta">{{ $label }}</p>
                                <p class="mt-1 text-[17px] leading-[1.5] text-ink">{{ $value }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if ($reseaux)
                    <div class="mt-8 flex flex-wrap gap-2 border-t border-black/[.08] pt-6">
                        @foreach ($reseaux as $nom => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="rounded-full bg-white px-4 py-2 text-[14px] text-ink transition hover:bg-ink hover:text-white">{{ $nom }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="aspect-[4/3] overflow-hidden rounded-[28px] bg-surface" data-reveal style="--reveal-delay: 90ms">
                <iframe title="Carte du siège BWAN HOLDING" class="h-full w-full grayscale-[.3]" loading="lazy" src="{{ $settings['google_maps_url'] ?? 'https://www.google.com/maps?q=Abidjan&output=embed' }}"></iframe>
            </div>
        </div>

        <form method="POST" action="{{ route('public.contact.store') }}" class="card h-fit p-8 md:p-12" data-reveal style="--reveal-delay: 120ms">
            @csrf
            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
            <p class="eyebrow">Message</p>
            <h2 class="title mt-1">Envoyer une demande.</h2>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div>
                    <label for="c-nom" class="field-label">Nom complet</label>
                    <input id="c-nom" name="nom" required value="{{ old('nom') }}" autocomplete="name" class="field">
                </div>
                <div>
                    <label for="c-entreprise" class="field-label">Entreprise <span class="text-subtle">(facultatif)</span></label>
                    <input id="c-entreprise" name="entreprise" value="{{ old('entreprise') }}" autocomplete="organization" class="field">
                </div>
                <div>
                    <label for="c-email" class="field-label">Email</label>
                    <input id="c-email" name="email" required type="email" value="{{ old('email') }}" autocomplete="email" class="field">
                </div>
                <div>
                    <label for="c-tel" class="field-label">Téléphone <span class="text-subtle">(facultatif)</span></label>
                    <input id="c-tel" name="telephone" type="tel" value="{{ old('telephone') }}" autocomplete="tel" class="field">
                </div>
                <div>
                    <label for="c-sujet" class="field-label">Sujet</label>
                    <input id="c-sujet" name="sujet" required value="{{ old('sujet') }}" class="field">
                </div>
                <div>
                    <label for="c-type" class="field-label">Type de demande</label>
                    <select id="c-type" name="type_demande" required class="field">
                        @foreach (['Commercial', 'Partenariat', 'Recrutement', 'Média', 'Support'] as $type)
                            <option @selected(old('type_demande') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="c-message" class="field-label">Message</label>
                    <textarea id="c-message" name="message" required rows="6" class="field resize-none">{{ old('message') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button class="btn btn-primary w-full md:w-auto">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
