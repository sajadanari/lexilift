<div class="flex space-x-2">
    @if($can_edit)
        <a href="" class="text-blue-600 hover:text-blue-900">
            Edit
        </a>
    @endif
    <button wire:click="deleteUser({{ $item->id }})" class="text-red-600 hover:text-red-900">
        Delete {{ $item->name }}
    </button>
</div>
