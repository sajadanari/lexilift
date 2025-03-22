<div class="flex space-x-2">
    @if($can_edit)
        <button wire:click="$parent.editUser({{ $item->id }})" class="inline-flex text-white p-2 rounded-full hover:text-gray-900 hover:bg-gray-200 cursor-pointer">
            <span class="material-symbols-outlined">
                edit
            </span>
        </button>
    @endif
    <button wire:click="$parent.deleteUser({{ $item->id }})" class="inline-flex text-red p-2 rounded-full hover:text-red-900 hover:bg-gray-200 cursor-pointer">
        <span class="material-symbols-outlined">
            delete
        </span>
    </button>
</div>
