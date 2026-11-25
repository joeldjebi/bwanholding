<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Article;
use App\Models\Video;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return view('public.medias.index', [
            'seo' => ['title' => 'Médias - BWAN HOLDING', 'description' => 'Photothèque, BWAN TV, actualités et communiqués du groupe.'],
        ]);
    }

    public function phototheque(Request $request)
    {
        return view('public.medias.phototheque', [
            'seo' => ['title' => 'Photothèque - BWAN HOLDING', 'description' => 'Albums photo officiels de BWAN HOLDING.'],
            'albums' => Album::query()
                ->with('photos')
                ->when($request->filled('categorie'), fn ($q) => $q->where('categorie', $request->query('categorie')))
                ->latest('date')
                ->paginate(9)
                ->withQueryString(),
            'categories' => Album::query()->select('categorie')->whereNotNull('categorie')->distinct()->pluck('categorie'),
        ]);
    }

    public function bwanTv()
    {
        return view('public.medias.bwan-tv', [
            'seo' => ['title' => 'BWAN TV - BWAN HOLDING', 'description' => 'Vidéos, interviews et contenus institutionnels BWAN HOLDING.'],
            'videos' => Video::query()->latest('date')->paginate(9),
        ]);
    }

    public function actualites()
    {
        return view('public.medias.actualites.index', [
            'seo' => ['title' => 'Actualités - BWAN HOLDING', 'description' => 'Dernières actualités du groupe BWAN HOLDING.'],
            'articles' => Article::query()->where('categorie', 'actualite')->where('statut', 'publie')->latest('date_publication')->paginate(9),
        ]);
    }

    public function actualiteShow(Article $article)
    {
        abort_unless($article->categorie === 'actualite', 404);

        return view('public.medias.actualites.show', [
            'seo' => ['title' => $article->titre.' - BWAN HOLDING', 'description' => str($article->contenu)->stripTags()->limit(155)->toString()],
            'article' => $article,
        ]);
    }

    public function communiques()
    {
        return view('public.medias.communiques.index', [
            'seo' => ['title' => 'Communiqués - BWAN HOLDING', 'description' => 'Communiqués officiels de BWAN HOLDING.'],
            'articles' => Article::query()->where('categorie', 'communique')->where('statut', 'publie')->latest('date_publication')->paginate(9),
        ]);
    }

    public function communiqueShow(Article $article)
    {
        abort_unless($article->categorie === 'communique', 404);

        return view('public.medias.communiques.show', [
            'seo' => ['title' => $article->titre.' - Communiqué BWAN HOLDING', 'description' => str($article->contenu)->stripTags()->limit(155)->toString()],
            'article' => $article,
        ]);
    }
}
