<div class="container mx-auto">
    <div class="mb-6">
        <h3 class="text-sm uppercase tracking-wide text-[var(--secondary-text-clr)] mb-2">Question</h3>
        <p class="text-2xl font-semibold text-[var(--text-clr)]">{{ $word->word }}</p>
    </div>

    <div class="space-y-4">
        @foreach($options as $option)
            <label class="block transition-all duration-200 ease-in-out
                {{ $isAnswered ? 'cursor-not-allowed' : 'hover:transform hover:scale-102 cursor-pointer' }}">
                <div class="">
                    <input type="radio"
                           name="answer"
                           value="{{ $option }}"
                           wire:model="selectedOption"
                           class="absolute opacity-0"
                           {{ $isAnswered ? 'disabled' : '' }}>
                    <div wire:click="{{ $isAnswered ? '' : 'submitAnswer(\'' . $option . '\')' }}"
                        class="p-4 rounded-xl border-2 transition-all duration-200
                        {{ !$isAnswered ? 'border-[var(--line-clr)] hover:border-[var(secondary-clr)] hover:bg-[var(--hover-clr)]' : '' }}
                        {{ $isAnswered && $option === $correct ? 'border-green-500 bg-green-50' : '' }}
                        {{ $isAnswered && $option === $selectedOption && $option !== $correct ? 'border-red-500 bg-red-50' : '' }}
                        {{ $isAnswered && $option !== $selectedOption ? 'border-[var(--line-clr)] text-[var(--secondary-text-clr)]' : '' }}">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-4
                                {{ !$isAnswered ? 'text-[var(--text-clr)]' : '' }}
                                {{ $isAnswered && $option === $correct ? 'bg-green-500 text-white p-3' : '' }}
                                {{ $isAnswered && $option === $selectedOption && $option !== $correct ? 'bg-red-500 text-white p-3' : '' }}">
                                @if(!$isAnswered)
                                    <span class="material-symbols-outlined text-xl">circle</span>
                                @elseif($isAnswered && $option === $correct)
                                    <span class="material-symbols-outlined text-xl">check</span>
                                @elseif($isAnswered && $option === $selectedOption && $option !== $correct)
                                    <span class="material-symbols-outlined text-xl">close</span>
                                @endif
                            </div>
                            <span class="text-lg font-medium
                                {{ $isAnswered && $option === $correct ? 'text-green-700' : '' }}
                                {{ $isAnswered && $option === $selectedOption && $option !== $correct ? 'text-red-700' : 'text-[var(--text-clr)]' }}">
                                {{ $option }}
                                @php
                                    if (env('APP_ENV') === 'local' && $option === $correct) {
                                        echo '<br><small class="text-gray-500">Correct</small>';
                                    }
                                @endphp
                            </span>
                        </div>
                    </div>
                </div>
            </label>
        @endforeach
    </div>
</div>
