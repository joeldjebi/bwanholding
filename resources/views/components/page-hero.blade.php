@props([
    'eyebrow' => null,
    'title',
    'lead' => null,
    'align' => 'center',
    'tone' => 'light',
])

@php
    $centered = $align === 'center';
    $dark = $tone === 'dark';
@endphp

<section @class(['relative overflow-hidden', 'bg-night text-white' => $dark, 'bg-white' => ! $dark])>
    @unless ($dark)
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 -top-40 mx-auto h-[420px] max-w-4xl rounded-full bg-[radial-gradient(closest-side,rgba(11,79,63,.08),transparent)] blur-2xl"></div>
    @endunless
    <div @class(['wrap relative pt-16 pb-14 md:pt-28 md:pb-20', 'text-center' => $centered])>
        <div class="hero-fade">
            @isset($back)
                <div @class(['mb-8', 'flex justify-center' => $centered])>{{ $back }}</div>
            @endisset
            @if ($eyebrow)
                <p @class(['eyebrow', '!text-[#6fd3b0]' => $dark])>{{ $eyebrow }}</p>
            @endif
            <h1 @class(['display mt-3', 'mx-auto max-w-4xl' => $centered, 'max-w-4xl' => ! $centered])>{{ $title }}</h1>
            @if ($lead)
                <p @class(['lead mt-6', 'mx-auto max-w-2xl' => $centered, 'max-w-2xl' => ! $centered, '!text-white/70' => $dark])>{{ $lead }}</p>
            @endif
            @if (trim($slot))
                <div @class(['mt-10', 'flex flex-wrap items-center justify-center gap-x-6 gap-y-4' => $centered])>{{ $slot }}</div>
            @endif
        </div>
    </div>
</section>
