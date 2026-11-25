<?php

use App\Http\Controllers\Public\CarriereController;
use App\Http\Controllers\Public\CachedMediaController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\DomaineController;
use App\Http\Controllers\Public\EntrepriseController;
use App\Http\Controllers\Public\GroupeController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\MediaController;
use App\Http\Controllers\Public\PartenaireController;
use App\Http\Controllers\Public\RealisationController;
use App\Models\Article;
use App\Models\Entreprise;
use App\Models\OffreEmploi;
use App\Models\Realisation;
use Illuminate\Support\Facades\Route;

Route::name('public.')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/media-cache/{encoded}', CachedMediaController::class)
        ->withoutMiddleware([
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
        ])
        ->name('media-cache');
    Route::post('/contact-rapide', [HomeController::class, 'contact'])->name('home.contact');

    Route::get('/le-groupe', GroupeController::class)->name('groupe');
    Route::get('/domaines-activite', [DomaineController::class, 'index'])->name('domaines.index');

    Route::get('/entreprises-startups', [EntrepriseController::class, 'index'])->name('entreprises.index');
    Route::get('/entreprises-startups/{entreprise:slug}', [EntrepriseController::class, 'show'])->name('entreprises.show');

    Route::get('/realisations', [RealisationController::class, 'index'])->name('realisations.index');
    Route::get('/realisations/{realisation:slug}', [RealisationController::class, 'show'])->name('realisations.show');

    Route::prefix('medias')->name('medias.')->controller(MediaController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/phototheque', 'phototheque')->name('phototheque');
        Route::get('/bwan-tv', 'bwanTv')->name('bwan-tv');
        Route::get('/actualites', 'actualites')->name('actualites.index');
        Route::get('/actualites/{article:slug}', 'actualiteShow')->name('actualites.show');
        Route::get('/communiques', 'communiques')->name('communiques.index');
        Route::get('/communiques/{article:slug}', 'communiqueShow')->name('communiques.show');
    });

    Route::get('/carrieres', [CarriereController::class, 'index'])->name('carrieres.index');
    Route::post('/carrieres/candidature-spontanee', [CarriereController::class, 'spontaneous'])->name('carrieres.spontaneous');
    Route::get('/carrieres/{offreEmploi:slug}', [CarriereController::class, 'show'])->name('carrieres.show');
    Route::post('/carrieres/{offreEmploi:slug}/postuler', [CarriereController::class, 'apply'])->name('carrieres.apply');

    Route::get('/partenaires', PartenaireController::class)->name('partenaires');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

Route::get('/sitemap.xml', function () {
    $staticRoutes = [
        route('public.home'),
        route('public.groupe'),
        route('public.domaines.index'),
        route('public.entreprises.index'),
        route('public.realisations.index'),
        route('public.medias.index'),
        route('public.medias.phototheque'),
        route('public.medias.bwan-tv'),
        route('public.medias.actualites.index'),
        route('public.medias.communiques.index'),
        route('public.carrieres.index'),
        route('public.partenaires'),
        route('public.contact.index'),
    ];

    $urls = collect($staticRoutes)
        ->merge(Entreprise::query()->pluck('slug')->map(fn ($slug) => route('public.entreprises.show', $slug)))
        ->merge(Realisation::query()->pluck('slug')->map(fn ($slug) => route('public.realisations.show', $slug)))
        ->merge(Article::query()->where('statut', 'publie')->where('categorie', 'actualite')->pluck('slug')->map(fn ($slug) => route('public.medias.actualites.show', $slug)))
        ->merge(Article::query()->where('statut', 'publie')->where('categorie', 'communique')->pluck('slug')->map(fn ($slug) => route('public.medias.communiques.show', $slug)))
        ->merge(OffreEmploi::query()->where('statut', 'ouverte')->pluck('slug')->map(fn ($slug) => route('public.carrieres.show', $slug)));

    return response()
        ->view('sitemap', ['urls' => $urls], 200)
        ->header('Content-Type', 'application/xml');
});
