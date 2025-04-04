@props(['word'])

@if($word->pronunciation)
<div class="mb-3 flex items-center gap-2">
    <h6 class="text-sm font-medium text-gray-500">Pronunciation:</h3>
    <span class="text-[var(--secondary-text-clr)]">/{{ $word->pronunciation }}/</span>

</div>
@endif
