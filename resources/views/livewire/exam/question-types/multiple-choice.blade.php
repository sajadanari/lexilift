<div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
    <p class="text-gray-800"><strong>Word:</strong> {{ $word->word }}</p>
    <div class="space-y-3">
        @foreach($options as $option)
            <label class="flex items-center space-x-3 cursor-pointer {{ $isAnswered ? 'cursor-not-allowed' : '' }}">
                <input type="radio"
                       name="answer"
                       value="{{ $option }}"
                       wire:model="selectedOption"
                       class="form-radio"
                       {{ $isAnswered ? 'disabled' : '' }}>
                <span wire:click="{{ $isAnswered ? '' : 'submitAnswer(\'' . $option . '\')' }}"
                      class="text-gray-700 py-2 px-4 rounded-md w-full
                      {{ $isAnswered && $option === $correct ? 'bg-green-100 text-green-800' : '' }}
                      {{ $isAnswered && $option === $selectedOption && $option !== $correct ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $option }}
                </span>
            </label>
        @endforeach
    </div>
</div>
