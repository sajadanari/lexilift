<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Review</h1>
    </div>

    <div>
        @foreach ($words as $word)
            {{-- Word Cart --}}
            <div class="bg-white p-6 rounded-lg shadow-sm mb-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-700">{{ $word->word }}</h2>
                    <div class="flex items
                    -center space-x-4">
                        <button wire:click="editWord({{ $word->id }})"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                            Edit
                        </button>
                        <button wire:click="deleteWord({{ $word->id }})"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg shadow-sm hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-50">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $words->links() }}
    </div>
</div>
