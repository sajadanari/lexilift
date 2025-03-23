@props([
    'title',
    'content',
    'centerTitle' => false,
    'italic' => false,
    'persian' => false
])

<div class="mb-3">
    <h3 class="text-sm font-medium text-gray-500 {{ $centerTitle ? 'text-center' : '' }}">{{ $title }}</h3>
    <p class="text-gray-700 {{ $italic ? 'italic' : '' }} {{ $persian ? 'persian' : '' }}">
        {{ $italic ? '"'.$content.'"' : $content }}
    </p>
</div>
