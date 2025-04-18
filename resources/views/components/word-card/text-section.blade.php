@props([
    'title',
    'content',
    'centerTitle' => false,
    'italic' => false,
    'persian' => false
])

<div class="mb-3">
    <h6 class="{{ $centerTitle ? 'text-center' : '' }}">{{ $title }}</h3>
    <p class="text-[var(--secondary-text-clr)] {{ $italic ? 'italic' : '' }} {{ $persian ? 'persian' : '' }}">
        {{ $italic ? '"'.$content.'"' : $content }}
    </p>
</div>
