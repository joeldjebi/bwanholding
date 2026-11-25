@php
    $title = $seo['title'] ?? 'BWAN HOLDING';
    $description = $seo['description'] ?? 'Groupe multisectoriel africain.';
    $nav = [
        ['label' => 'Le Groupe', 'route' => 'public.groupe', 'active' => ['public.groupe']],
        ['label' => 'Domaines', 'route' => 'public.domaines.index', 'active' => ['public.domaines.*']],
        ['label' => 'Entreprises', 'route' => 'public.entreprises.index', 'active' => ['public.entreprises.*']],
        ['label' => 'Réalisations', 'route' => 'public.realisations.index', 'active' => ['public.realisations.*']],
        ['label' => 'Médias', 'route' => 'public.medias.index', 'active' => ['public.medias.*']],
        ['label' => 'Carrières', 'route' => 'public.carrieres.index', 'active' => ['public.carrieres.*']],
        ['label' => 'Partenaires', 'route' => 'public.partenaires', 'active' => ['public.partenaires']],
    ];
    $footerColumns = [
        'Le groupe' => [
            ['Présentation', 'public.groupe'],
            ['Domaines d’activité', 'public.domaines.index'],
            ['Entreprises & startups', 'public.entreprises.index'],
            ['Réalisations', 'public.realisations.index'],
        ],
        'Médias' => [
            ['Actualités', 'public.medias.actualites.index'],
            ['Communiqués', 'public.medias.communiques.index'],
            ['Photothèque', 'public.medias.phototheque'],
            ['BWAN TV', 'public.medias.bwan-tv'],
        ],
        'Nous rejoindre' => [
            ['Carrières', 'public.carrieres.index'],
            ['Partenaires', 'public.partenaires'],
            ['Contact', 'public.contact.index'],
        ],
    ];
@endphp
<!doctype html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#ffffff">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <script>document.documentElement.classList.add('js')</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    <style>
        [data-header].is-scrolled { box-shadow: 0 1px 0 rgb(0 0 0 / .08); }
    </style>
</head>
<body class="min-h-screen">
    <a href="#contenu" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-full focus:bg-white focus:px-4 focus:py-2 focus:shadow-lg">Aller au contenu</a>

    <header
        x-data="{ open: false }"
        x-effect="document.body.classList.toggle('overflow-hidden', open)"
        @keydown.escape.window="open = false"
        data-header
        class="sticky top-0 z-50 bg-white/75 backdrop-blur-xl backdrop-saturate-[1.8] transition-shadow duration-300"
    >
        <nav class="wrap-wide flex h-14 items-center justify-between gap-6 md:h-16" aria-label="Navigation principale">
            <a href="{{ route('public.home') }}" class="flex shrink-0 items-center" aria-label="Accueil BWAN HOLDING">
                <img src="{{ asset('assets/logo/logobh.png') }}" alt="BWAN HOLDING" class="h-9 w-auto object-contain md:h-10">
            </a>

            <div class="hidden items-center gap-7 lg:flex">
                @foreach ($nav as $item)
                    @php $isActive = request()->routeIs(...$item['active']); @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'relative text-[14px] transition-colors duration-200',
                            'text-ink font-medium' => $isActive,
                            'text-ink/70 hover:text-ink' => ! $isActive,
                        ])
                        @if ($isActive) aria-current="page" @endif
                    >
                        {{ $item['label'] }}
                        @if ($isActive)
                            <span class="absolute inset-x-0 -bottom-[21px] mx-auto h-[2px] w-5 rounded-full bg-brand"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('public.contact.index') }}" class="btn btn-primary btn-sm hidden lg:inline-flex">Nous contacter</a>
                <button
                    type="button"
                    class="relative -mr-2 flex h-11 w-11 items-center justify-center lg:hidden"
                    @click="open = ! open"
                    :aria-expanded="open.toString()"
                    aria-controls="menu-mobile"
                    aria-label="Menu"
                >
                    <span class="absolute h-[1.5px] w-[18px] rounded-full bg-ink transition duration-300" :class="open ? 'rotate-45' : '-translate-y-[4px]'"></span>
                    <span class="absolute h-[1.5px] w-[18px] rounded-full bg-ink transition duration-300" :class="open ? '-rotate-45' : 'translate-y-[4px]'"></span>
                </button>
            </div>
        </nav>

        <div
            id="menu-mobile"
            x-show="open"
            x-cloak
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-x-0 top-14 bottom-0 overflow-y-auto bg-white lg:hidden"
        >
            <div class="wrap pt-6 pb-16">
                <a href="{{ route('public.home') }}" class="block py-2 text-[28px] font-semibold tracking-tight text-ink">Accueil</a>
                @foreach ($nav as $item)
                    @php $isActive = request()->routeIs(...$item['active']); @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        @class(['block py-2 text-[28px] font-semibold tracking-tight', 'text-brand' => $isActive, 'text-ink' => ! $isActive])
                        @if ($isActive) aria-current="page" @endif
                    >{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ route('public.contact.index') }}" class="btn btn-primary mt-10 w-full">Nous contacter</a>
            </div>
        </div>
    </header>

    <main id="contenu">
        @if (session('success'))
            <div class="wrap pt-6">
                <div role="status" class="flex items-center gap-3 rounded-2xl bg-brand-soft px-5 py-4 text-[15px] text-brand">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand text-[13px] text-white">✓</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="wrap pt-6">
                <div role="alert" class="rounded-2xl bg-[#fff1f0] px-5 py-4 text-[15px] text-[#b42318]">
                    <p class="font-medium">Veuillez corriger les champs indiqués.</p>
                    <ul class="mt-1 list-inside list-disc text-[14px] opacity-80">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-surface text-[12px] leading-[1.6] text-muted">
        <div class="wrap-wide pt-14 pb-10">
            <div class="grid gap-10 md:grid-cols-[1.4fr_repeat(3,1fr)_1.2fr]">
                <div>
                    <img src="{{ asset('assets/logo/logobh.png') }}" alt="BWAN HOLDING" class="h-10 w-auto object-contain">
                    <p class="mt-4 max-w-xs text-[13px]">Un groupe africain qui connecte technologie, mobilité, évènementiel, formation et tourisme pour créer des plateformes de croissance durables.</p>
                </div>
                @foreach ($footerColumns as $heading => $links)
                    <div>
                        <p class="text-[12px] font-semibold text-ink">{{ $heading }}</p>
                        <ul class="mt-3 grid gap-2">
                            @foreach ($links as [$label, $route])
                                <li><a href="{{ route($route) }}" class="transition-colors hover:text-ink hover:underline">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
                <div>
                    <p class="text-[12px] font-semibold text-ink">Contact</p>
                    <ul class="mt-3 grid gap-2">
                        <li>Fixe : <a href="tel:+2252733712914" class="hover:text-ink hover:underline">27 33 71 29 14</a></li>
                        <li>Mobile : <a href="tel:+2250778780606" class="hover:text-ink hover:underline">07 78 78 06 06</a> / <a href="tel:+2250556282876" class="hover:text-ink hover:underline">05 56 28 28 76</a></li>
                        <li><a href="mailto:infos@bwanholding.com" class="hover:text-ink hover:underline">infos@bwanholding.com</a></li>
                        <li><a href="mailto:Rh@bwanholding.com" class="hover:text-ink hover:underline">Rh@bwanholding.com</a></li>
                        <li><a href="mailto:bwanholding@gmail.com" class="hover:text-ink hover:underline">bwanholding@gmail.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 flex flex-col gap-2 border-t border-black/10 pt-6 md:flex-row md:items-center md:justify-between">
                <p>Copyright © {{ now()->year }} BWAN HOLDING. Tous droits réservés.</p>
                <p>Afrique de l’Ouest</p>
            </div>
        </div>
    </footer>
</body>
</html>
