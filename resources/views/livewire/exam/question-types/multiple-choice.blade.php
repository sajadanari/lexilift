<div class="bg-white p-8 rounded-2xl shadow-lg max-w-2xl mx-auto">
    <div class="mb-6">
        <h3 class="text-sm uppercase tracking-wide text-gray-500 mb-2">Question</h3>
        <p class="text-2xl font-semibold text-gray-800">{{ $word->word }}</p>
    </div>

    <div class="space-y-4">
        @foreach($options as $option)
            <label class="block transition-all duration-200 ease-in-out
                {{ $isAnswered ? 'cursor-not-allowed' : 'hover:transform hover:scale-102 cursor-pointer' }}">
                <div class="relative">
                    <input type="radio"
                           name="answer"
                           value="{{ $option }}"
                           wire:model="selectedOption"
                           class="absolute opacity-0"
                           {{ $isAnswered ? 'disabled' : '' }}>
                    <div wire:click="{{ $isAnswered ? '' : 'submitAnswer(\'' . $option . '\')' }}"
                         class="p-4 rounded-xl border-2 transition-all duration-200
                         {{ !$isAnswered ? 'border-gray-200 hover:border-blue-400 hover:bg-blue-50' : '' }}
                         {{ $isAnswered && $option === $correct ? 'border-green-500 bg-green-50' : '' }}
                         {{ $isAnswered && $option === $selectedOption && $option !== $correct ? 'border-red-500 bg-red-50' : '' }}">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-4
                                {{ !$isAnswered ? 'border-gray-300' : '' }}
                                {{ $isAnswered && $option === $correct ? 'border-green-500 bg-green-500' : '' }}
                                {{ $isAnswered && $option === $selectedOption && $option !== $correct ? 'border-red-500 bg-red-500' : '' }}">
                                @if($isAnswered && $option === $correct)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @elseif($isAnswered && $option === $selectedOption && $option !== $correct)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </div>
                            <span class="text-lg font-medium
                                {{ $isAnswered && $option === $correct ? 'text-green-700' : '' }}
                                {{ $isAnswered && $option === $selectedOption && $option !== $correct ? 'text-red-700' : 'text-gray-700' }}">
                                {{ $option }}
                            </span>
                        </div>
                    </div>
                </div>
            </label>
        @endforeach
    </div>
</div>
