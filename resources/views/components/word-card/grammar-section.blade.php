@props(['word'])

@if($word->part_of_speech == \App\Enums\PartOfSpeech::NOUN)
    <div class="mb-3">
        <h3 class="text-sm font-medium text-gray-500">Grammar Details:</h3>
        <div class="mt-1 space-y-1">
            <div class="text-gray-700">
                <span class="font-medium">Type:</span>
                {{ $word->countable ? 'Countable' : 'Uncountable' }} Noun
            </div>
            @if($word->plural)
                <div class="text-gray-700">
                    <span class="font-medium">Plural:</span>
                    {{ $word->plural }}
                </div>
            @endif
        </div>
    </div>
@endif
