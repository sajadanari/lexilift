<div class="flex items-center gap-2">
    @if($can_edit)
        <button
            wire:click="$parent.editWord({{ $item->id }})"
            class="p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-all duration-200 flex"
            title="Edit"
        >
            <span class="material-symbols-outlined text-[20px]">edit</span>
        </button>
    @endif
    <button
        wire:click="$parent.deleteWord({{ $item->id }})"
        class="p-2 text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-all duration-200 flex"
        title="Delete"
    >
        <span class="material-symbols-outlined text-[20px]">delete</span>
    </button>
</div>
