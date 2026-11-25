@extends('layouts.public')

@section('content')
<section class="wrap pt-12 pb-20 md:pt-20 md:pb-28">
    <a href="{{ route('public.carrieres.index') }}" class="back-link">Toutes les offres</a>
    <div class="mt-10 grid gap-12 lg:grid-cols-[1fr_400px] lg:gap-16">
        <article class="hero-fade">
            <div class="flex flex-wrap gap-2">
                @foreach (array_filter([$offre->entite, $offre->type_contrat, $offre->localisation]) as $tag)
                    <span class="chip-soft">{{ $tag }}</span>
                @endforeach
            </div>
            <h1 class="mt-5 text-[36px] leading-[1.08] font-semibold tracking-[-0.03em] text-balance md:text-[56px]">{{ $offre->titre }}</h1>
            <div class="divider mt-10"></div>
            <div class="prose-apple mt-10">{!! nl2br(e($offre->description)) !!}</div>
        </article>

        <aside class="lg:sticky lg:top-24 lg:self-start">
            <form method="POST" action="{{ route('public.carrieres.apply', $offre) }}" enctype="multipart/form-data" class="tile p-7 md:p-8">
                @csrf
                <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                <p class="eyebrow">Candidature</p>
                <h2 class="title mt-1">Postuler à cette offre.</h2>
                <div class="mt-7 grid gap-4">
                    <div>
                        <label for="ap-nom" class="field-label">Nom complet</label>
                        <input id="ap-nom" name="nom" required value="{{ old('nom') }}" autocomplete="name" class="field">
                    </div>
                    <div>
                        <label for="ap-email" class="field-label">Email</label>
                        <input id="ap-email" name="email" required type="email" value="{{ old('email') }}" autocomplete="email" class="field">
                    </div>
                    <div>
                        <label for="ap-tel" class="field-label">Téléphone <span class="text-subtle">(facultatif)</span></label>
                        <input id="ap-tel" name="telephone" type="tel" value="{{ old('telephone') }}" autocomplete="tel" class="field">
                    </div>
                    <div>
                        <label for="ap-msg" class="field-label">Message <span class="text-subtle">(facultatif)</span></label>
                        <textarea id="ap-msg" name="message" rows="4" class="field resize-none">{{ old('message') }}</textarea>
                    </div>
                    <div>
                        <label for="ap-cv" class="field-label">CV (PDF, DOC, DOCX)</label>
                        <input id="ap-cv" name="cv" required type="file" accept=".pdf,.doc,.docx" class="field">
                    </div>
                    <button class="btn btn-primary mt-2 w-full">Envoyer ma candidature</button>
                </div>
            </form>
        </aside>
    </div>
</section>
@endsection
