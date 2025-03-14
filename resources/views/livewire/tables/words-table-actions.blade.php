<button wire:click="$dispatch('edit-word', { wordId: {{ $word->id }} })" class="hover:bg-gray-200 p-2 rounded cursor-pointer">
    Edit
</button>