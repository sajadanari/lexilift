<div class="flex space-x-2">
    @if($can_edit)
        <a href="" class="inline-flex text-white p-2 rounded-full hover:text-gray-900 hover:bg-gray-200">
            <span class="material-symbols-outlined">
                edit
            </span>
        </a>
    @endif
    <button wire:click="deleteUser({{ $item->id }})" class="inline-flex text-red p-2 rounded-full hover:text-red-900 hover:bg-gray-200 cursor-pointer">
        <span class="material-symbols-outlined">
            delete
        </span>
    </button>
</div>
