@props([
    'eyebrow' => null,
    'title',
    'lead' => null,
    'align' => 'center',
    'dark' => false,
])

@php $centered = $align === 'center'; @endphp

<div {{ $attributes->class(['flex flex-wrap items-end justify-between gap-6' => ! $centered && isset($action), 'text-center' => $centered]) }} data-reveal>
    <div @class(['mx-auto max-w-3xl' => $centered, 'max-w-2xl' => ! $centered])>
        @if ($eyebrow)
            <p @class(['eyebrow', '!text-[#6fd3b0]' => $dark])>{{ $eyebrow }}</p>
        @endif
        <h2 class="headline mt-2">{{ $title }}</h2>
        @if ($lead)
            <p @class(['lead mt-5', '!text-white/65' => $dark])>{{ $lead }}</p>
        @endif
    </div>
    @isset($action)
        <div @class(['mt-6' => $centered])>{{ $action }}</div>
    @endisset
</div>
