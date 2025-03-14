<button wire:click="$dispatch('edit-word', { wordId: {{ $word->id }} })" class="inline-flex items-center hover:bg-gray-300 p-2 rounded cursor-pointer">
    <i class="material-symbols-outlined">edit_square</i>
</button>

<button wire:click="$dispatch('delete-word', { wordId: {{ $word->id }} })" class="inline-flex items-center text-red-500 hover:bg-gray-300 p-2 rounded cursor-pointer">
    <i class="material-symbols-outlined">delete</i>
</button>