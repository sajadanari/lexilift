@props(['word'])

@if($word->pronunciation)
<div class="mb-3 flex items-center gap-2">
    <h3 class="text-sm font-medium text-gray-500">Pronunciation:</h3>
    <span class="text-gray-700">/{{ $word->pronunciation }}/</span>
    @if($word->audio)
        <button
            type="button"
            wire:click="playAudio('{{ $word->audio }}')"
            class="text-blue-600 hover:text-blue-800"
        >
            <span class="material-symbols-outlined text-lg">
                volume_up
            </span>
        </button>
    @endif
</div>
@endif
