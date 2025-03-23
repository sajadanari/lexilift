@props(['word'])

@if($word->pronunciation)
<div class="mb-3 flex items-center gap-2">
    <h3 class="text-sm font-medium text-gray-500">Pronunciation:</h3>
    <span class="text-gray-700">/{{ $word->pronunciation }}/</span>

</div>
@endif
