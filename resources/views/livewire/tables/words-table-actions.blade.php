<button wire:click="$emitTo('my-words.my-words', 'test')" class="hover:bg-gray-200 p-2 rounded cursor-pointer">
    test {{ $word->id }}
</button>