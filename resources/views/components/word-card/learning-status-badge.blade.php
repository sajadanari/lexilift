@props(['score'])

@php
    $level = \App\Enums\WordLevel::fromScore($score);
    [$bgColor, $textColor, $icon, $text] = match($level) {
        \App\Enums\WordLevel::WEAK => ['bg-red-100', 'text-red-700', 'error', 'Needs Practice'],
        \App\Enums\WordLevel::MEDIUM => ['bg-yellow-100', 'text-yellow-700', 'check_circle', 'Learning'],
        \App\Enums\WordLevel::STRONG => ['bg-green-100', 'text-green-700', 'done_all', 'Well Known'],
    };
@endphp

<div {{ $attributes->merge(['class' => "flex items-center gap-1 px-2 py-1 rounded-full {$bgColor} {$textColor}"]) }}>
    <span class="material-symbols-outlined text-sm">{{ $icon }}</span>
    <span class="text-sm font-medium">{{ $text }}</span>
</div>
