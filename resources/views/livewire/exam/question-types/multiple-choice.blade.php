<div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
    <p class="text-gray-800"><strong>Word:</strong> {{ $word->word }}</p>
    <div class="space-y-3">
        @foreach($options as $option)
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="radio" name="answer" class="form-radio text-blue-600">
                <span wire:click="submitAnswer('{{ $option }}')"
                      class="text-gray-700">{{ $option }}</span>
            </label>
        @endforeach
    </div>
</div>
