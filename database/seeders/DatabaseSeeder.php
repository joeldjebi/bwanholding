<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Article;
use App\Models\ChiffreCle;
use App\Models\Domaine;
use App\Models\Entreprise;
use App\Models\OffreEmploi;
use App\Models\Partenaire;
use App\Models\Photo;
use App\Models\Realisation;
use App\Models\Setting;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@bwanholding.com',
        ], [
            'name' => 'Admin BWAN',
            'password' => Hash::make('12345678'),
        ]);

        $domaines = collect([
            ['nom' => 'Technologie', 'icone' => '⌁', 'description' => 'Solutions digitales, plateformes métier, automatisation et accompagnement à la transformation numérique.'],
            ['nom' => 'Services Automobile', 'icone' => '◈', 'description' => 'Services de mobilité, maintenance, conciergerie automobile, sourcing et gestion de flotte.'],
            ['nom' => 'Évènementiel', 'icone' => '✦', 'description' => 'Conception, production et coordination d’évènements corporate, institutionnels et grand public.'],
            ['nom' => 'Formation', 'icone' => '◎', 'description' => 'Programmes de montée en compétence, bootcamps, ateliers pratiques et ingénierie pédagogique.'],
            ['nom' => 'Tourisme', 'icone' => '◇', 'description' => 'Expériences locales, circuits, hospitalité, voyages d’affaires et services de destination.'],
        ])->mapWithKeys(function (array $domaine, int $index) {
            $model = Domaine::query()->updateOrCreate([
                'slug' => Str::slug($domaine['nom']),
            ], $domaine + ['ordre' => $index + 1]);

            return [$model->slug => $model];
        });

        ChiffreCle::query()->upsert([
            ['libelle' => 'Pôles métiers', 'valeur' => '5', 'icone' => 'grid', 'ordre' => 1],
            ['libelle' => 'Projets structurants', 'valeur' => '+24', 'icone' => 'briefcase', 'ordre' => 2],
            ['libelle' => 'Partenaires actifs', 'valeur' => '+18', 'icone' => 'network', 'ordre' => 3],
            ['libelle' => 'Marchés adressés', 'valeur' => 'Afrique', 'icone' => 'map', 'ordre' => 4],
        ], ['libelle'], ['valeur', 'icone', 'ordre']);

        $enterpriseImage = $this->storeRemoteImage('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=900&q=80', 'entreprises', 'bwan-digital.jpg');
        $mobilityImage = $this->storeRemoteImage('https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80', 'entreprises', 'bwan-mobility.jpg');
        $eventsImage = $this->storeRemoteImage('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=900&q=80', 'entreprises', 'bwan-events.jpg');

        collect([
            ['nom' => 'BWAN Digital Lab', 'domaine' => 'technologie', 'logo' => $enterpriseImage, 'description' => 'Studio digital du groupe dédié aux plateformes web, outils métier, automatisation et conseil produit.', 'services' => ['Applications web', 'Conseil produit', 'Automatisation', 'Data & tableaux de bord'], 'cible' => 'PME, institutions et startups', 'statut' => 'active'],
            ['nom' => 'BWAN Mobility Services', 'domaine' => 'services-automobile', 'logo' => $mobilityImage, 'description' => 'Entité dédiée aux services automobiles, à la gestion de flotte et aux solutions de mobilité professionnelle.', 'services' => ['Gestion de flotte', 'Maintenance', 'Sourcing véhicules', 'Conciergerie automobile'], 'cible' => 'Entreprises et professionnels', 'statut' => 'active'],
            ['nom' => 'BWAN Events', 'domaine' => 'evenementiel', 'logo' => $eventsImage, 'description' => 'Agence évènementielle intégrée pour concevoir, produire et coordonner des expériences premium.', 'services' => ['Production évènementielle', 'Scénographie', 'Coordination terrain', 'Relations publiques'], 'cible' => 'Marques, institutions et organisations', 'statut' => 'active'],
            ['nom' => 'BWAN Academy', 'domaine' => 'formation', 'logo' => $this->storeRemoteImage('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80', 'entreprises', 'bwan-academy.jpg'), 'description' => 'Pôle formation pour développer les compétences digitales, commerciales, managériales et opérationnelles.', 'services' => ['Bootcamps', 'Ateliers corporate', 'Mentorat', 'Ingénierie pédagogique'], 'cible' => 'Jeunes talents et entreprises', 'statut' => 'active'],
            ['nom' => 'BWAN Travel & Experience', 'domaine' => 'tourisme', 'logo' => $this->storeRemoteImage('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80', 'entreprises', 'bwan-travel.jpg'), 'description' => 'Marque tourisme orientée expériences locales, voyages d’affaires et services de destination.', 'services' => ['Circuits locaux', 'Voyages corporate', 'Accueil VIP', 'Expériences culturelles'], 'cible' => 'Voyageurs, entreprises et diasporas', 'statut' => 'incubation'],
        ])->each(function (array $item, int $index) use ($domaines) {
            $domaineSlug = $item['domaine'];
            unset($item['domaine']);

            Entreprise::query()->updateOrCreate([
                'slug' => Str::slug($item['nom']),
            ], $item + [
                'domaine_id' => $domaines[$domaineSlug]->id,
                'ordre' => $index + 1,
            ]);
        });

        collect([
            [
                'titre' => 'Plateforme digitale de gestion opérationnelle',
                'secteur' => 'Technologie',
                'problematique' => 'Une organisation multisite avait besoin d’unifier le suivi de ses demandes, équipes et indicateurs.',
                'solution' => 'Conception d’une plateforme web modulaire avec espaces utilisateurs, reporting et workflows de validation.',
                'resultat' => 'Réduction des délais de traitement, meilleure visibilité managériale et adoption rapide par les équipes.',
                'images' => [
                    $this->storeRemoteImage('https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80', 'realisations', 'plateforme-digitale-1.jpg'),
                    $this->storeRemoteImage('https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=1200&q=80', 'realisations', 'plateforme-digitale-2.jpg'),
                ],
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'titre' => 'Programme de formation métiers digitaux',
                'secteur' => 'Formation',
                'problematique' => 'Des jeunes talents devaient acquérir rapidement des compétences pratiques et employables.',
                'solution' => 'Création d’un parcours intensif mêlant ateliers, projets réels, mentorat et évaluation continue.',
                'resultat' => 'Une cohorte opérationnelle, capable de livrer des projets concrets et de rejoindre des équipes produit.',
                'images' => [
                    $this->storeRemoteImage('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80', 'realisations', 'formation-digitale-1.jpg'),
                    $this->storeRemoteImage('https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80', 'realisations', 'formation-digitale-2.jpg'),
                ],
                'video_url' => null,
            ],
            [
                'titre' => 'Production d’un forum institutionnel',
                'secteur' => 'Évènementiel',
                'problematique' => 'Un partenaire institutionnel souhaitait réunir décideurs, entreprises et médias dans un format maîtrisé.',
                'solution' => 'Pilotage de la scénographie, des prestataires, du protocole, de la régie et des contenus.',
                'resultat' => 'Un évènement fluide, premium et documenté, avec une forte satisfaction des invités et intervenants.',
                'images' => [
                    $this->storeRemoteImage('https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=1200&q=80', 'realisations', 'forum-institutionnel-1.jpg'),
                    $this->storeRemoteImage('https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80', 'realisations', 'forum-institutionnel-2.jpg'),
                ],
                'video_url' => null,
            ],
        ])->each(function (array $realisation) {
            Realisation::query()->updateOrCreate([
                'slug' => Str::slug($realisation['titre']),
            ], $realisation);
        });

        collect([
            ['titre' => 'BWAN HOLDING renforce son portefeuille multisectoriel', 'categorie' => 'actualite', 'contenu' => 'BWAN HOLDING poursuit la structuration de ses pôles autour de services utiles aux entreprises, institutions et communautés africaines.', 'image' => $this->storeRemoteImage('https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1200&q=80', 'articles', 'portefeuille-multisectoriel.jpg')],
            ['titre' => 'Lancement d’un cycle de formation orienté compétences terrain', 'categorie' => 'actualite', 'contenu' => 'BWAN Academy lance un cycle de formation pratique pour préparer les talents aux besoins réels des organisations.', 'image' => $this->storeRemoteImage('https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80', 'articles', 'cycle-formation.jpg')],
            ['titre' => 'Communiqué officiel sur la gouvernance du groupe', 'categorie' => 'communique', 'contenu' => 'BWAN HOLDING rappelle son engagement en faveur d’une gouvernance transparente, d’une exécution rigoureuse et d’une croissance responsable.', 'image' => $this->storeRemoteImage('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80', 'articles', 'communique-gouvernance.jpg')],
        ])->each(function (array $article) {
            Article::query()->updateOrCreate([
                'slug' => Str::slug($article['titre']),
            ], $article + [
                'statut' => 'publie',
                'date_publication' => now()->subDays(rand(2, 18))->toDateString(),
            ]);
        });

        $album = Album::query()->updateOrCreate([
            'titre' => 'Vie du groupe et opérations terrain',
        ], [
            'categorie' => 'Institutionnel',
            'date' => now()->subDays(10)->toDateString(),
        ]);

        collect([
            ['url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1000&q=80', 'name' => 'equipe-operationnelle.jpg', 'legende' => 'Session de coordination opérationnelle'],
            ['url' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1000&q=80', 'name' => 'reunion-strategique.jpg', 'legende' => 'Réunion stratégique'],
            ['url' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1000&q=80', 'name' => 'atelier-digital.jpg', 'legende' => 'Atelier digital'],
            ['url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1000&q=80', 'name' => 'formation-collaborative.jpg', 'legende' => 'Formation collaborative'],
        ])->each(function (array $photo) use ($album) {
            Photo::query()->updateOrCreate([
                'album_id' => $album->id,
                'legende' => $photo['legende'],
            ], [
                'url' => $this->storeRemoteImage($photo['url'], 'albums', $photo['name']),
            ]);
        });

        collect([
            ['titre' => 'Présentation institutionnelle BWAN HOLDING', 'description' => 'Vision, portefeuille et ambitions du groupe.', 'url_embed' => 'https://www.youtube.com/embed/ysz5S6PUM-U', 'thumbnail' => $this->storeRemoteImage('https://images.unsplash.com/photo-1485846234645-a62644f84728?auto=format&fit=crop&w=1000&q=80', 'videos', 'presentation-bwan-tv.jpg')],
            ['titre' => 'Inside BWAN Academy', 'description' => 'Immersion dans les sessions de formation.', 'url_embed' => 'https://www.youtube.com/embed/jNQXAC9IVRw', 'thumbnail' => $this->storeRemoteImage('https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1000&q=80', 'videos', 'inside-academy.jpg')],
        ])->each(function (array $video, int $index) {
            Video::query()->updateOrCreate([
                'titre' => $video['titre'],
            ], $video + [
                'date' => now()->subDays($index + 4)->toDateString(),
            ]);
        });

        collect([
            ['titre' => 'Chef de projet digital', 'entite' => 'BWAN Digital Lab', 'type_contrat' => 'CDI', 'localisation' => 'Abidjan', 'description' => 'Piloter les projets digitaux, coordonner les parties prenantes, suivre les livrables et garantir la qualité opérationnelle.'],
            ['titre' => 'Responsable production évènementielle', 'entite' => 'BWAN Events', 'type_contrat' => 'CDD', 'localisation' => 'Abidjan', 'description' => 'Préparer les dispositifs de production, coordonner les prestataires et piloter les opérations terrain.'],
            ['titre' => 'Formateur outils numériques', 'entite' => 'BWAN Academy', 'type_contrat' => 'Freelance', 'localisation' => 'Hybride', 'description' => 'Animer des ateliers pratiques, accompagner les apprenants et contribuer aux supports pédagogiques.'],
        ])->each(function (array $offre) {
            OffreEmploi::query()->updateOrCreate([
                'slug' => Str::slug($offre['titre']),
            ], $offre + [
                'statut' => 'ouverte',
                'date_publication' => now()->subDays(rand(1, 12))->toDateString(),
            ]);
        });

        collect([
            ['nom' => 'Hub Innovation Afrique', 'categorie' => 'technique', 'logo' => $this->storeRemoteImage('https://images.unsplash.com/photo-1560179707-f14e90ef3623?auto=format&fit=crop&w=600&q=80', 'partenaires', 'hub-innovation.jpg'), 'ordre' => 1],
            ['nom' => 'Institut Leadership & Croissance', 'categorie' => 'institutionnel', 'logo' => $this->storeRemoteImage('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=600&q=80', 'partenaires', 'institut-leadership.jpg'), 'ordre' => 2],
            ['nom' => 'Mobility Network', 'categorie' => 'commercial', 'logo' => $this->storeRemoteImage('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=600&q=80', 'partenaires', 'mobility-network.jpg'), 'ordre' => 3],
        ])->each(fn (array $partenaire) => Partenaire::query()->updateOrCreate(['nom' => $partenaire['nom']], $partenaire));

        collect([
            'adresse' => 'Siège BWAN HOLDING, Abidjan, Côte d’Ivoire',
            'telephone' => 'Fixe : 27 33 71 29 14 / Mobile : 07 78 78 06 06 / 05 56 28 28 76',
            'email' => 'infos@bwanholding.com / Rh@bwanholding.com / bwanholding@gmail.com',
            'google_maps_url' => 'https://www.google.com/maps?q=Abidjan&output=embed',
            'linkedin' => 'https://www.linkedin.com/company/bwan-holding',
            'facebook' => 'https://www.facebook.com/',
            'instagram' => 'https://www.instagram.com/',
        ])->each(fn (string $value, string $key) => Setting::query()->updateOrCreate(['cle' => $key], ['valeur' => $value]));
    }

    private function storeRemoteImage(string $url, string $directory, string $filename): string
    {
        $path = trim($directory, '/').'/'.$filename;
        $disk = $this->preferredMediaDisk();

        try {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->url($path);
            }

            $response = Http::timeout(20)->retry(2, 300)->get($url);

            if (! $response->successful()) {
                return $url;
            }

            Storage::disk($disk)->put($path, $response->body(), ['visibility' => 'public']);

            return Storage::disk($disk)->url($path);
        } catch (Throwable) {
            if ($disk !== 'public') {
                try {
                    $response = Http::timeout(20)->retry(2, 300)->get($url);

                    if ($response->successful()) {
                        Storage::disk('public')->put($path, $response->body());

                        return Storage::disk('public')->url($path);
                    }
                } catch (Throwable) {
                    return $url;
                }
            }

            return $url;
        }
    }

    private function preferredMediaDisk(): string
    {
        return filled(config('filesystems.disks.wasabi.key'))
            && filled(config('filesystems.disks.wasabi.secret'))
            && filled(config('filesystems.disks.wasabi.bucket'))
            ? 'wasabi'
            : 'public';
    }
}
