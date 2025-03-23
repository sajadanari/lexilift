@props(['word'])

<div class="flex gap-2 items-center mb-3">
    @if($word->difficulty_level)
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            Level {{ $word->difficulty_level->label() }}
        </span>
    @endif

    @if($word->frequency)
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{
            match($word->frequency) {
                \App\Enums\FrequencyLevel::HIGH => 'bg-green-100 text-green-800',
                \App\Enums\FrequencyLevel::MEDIUM => 'bg-yellow-100 text-yellow-800',
                \App\Enums\FrequencyLevel::LOW => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800'
            }
        }}">
            {{ $word->frequency->label() }}
        </span>
    @endif
</div>
