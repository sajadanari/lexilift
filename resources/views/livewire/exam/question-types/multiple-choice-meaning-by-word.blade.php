{{--
    Multiple Choice Question Component
    Displays a word and its possible meanings as multiple choice options
    Features:
    - Shows the target word
    - Presents 4 options (1 correct, 3 wrong)
    - Visual feedback for correct/incorrect answers
    - Disabled state after answering
--}}

<div class="container mx-auto">
    {{-- Question Header Section --}}
    <div class="mb-6">
        <h3 class="text-sm uppercase tracking-wide text-[var(--secondary-text-clr)] mb-2">Question</h3>
        <p class="text-[var(--secondary-text-clr)]">Choose the correct meaning of the word:</p>
        <p class="text-2xl font-semibold text-[var(--text-clr)]">{{ $word->word }}</p>
    </div>

    {{-- Options List --}}
    <div class="space-y-4">
        @foreach ($options as $option)
            {{-- Option Container --}}
            <label @class([
                'block transition-all duration-200 ease-in-out',
                'cursor-not-allowed' => $isAnswered,
                'hover:transform hover:scale-102 cursor-pointer' => !$isAnswered,
            ])>
                <div>
                    {{-- Hidden Radio Input --}}
                    <input type="radio" name="answer" value="{{ $option }}" wire:model="selectedOption"
                        class="absolute opacity-0" {{ $isAnswered ? 'disabled' : '' }}>

                    {{-- Option Card --}}
                    <div wire:click="{{ $isAnswered ? '' : 'submitAnswer(\'' . $option . '\')' }}"
                        @class([
                            'p-4 rounded-xl border-2 transition-all duration-200',
                            // Default state
                            'border-[var(--line-clr)] hover:border-[var(secondary-clr)] hover:bg-[var(--hover-clr)]' => !$isAnswered,
                            // Correct answer state
                            'border-green-500 bg-green-50' => $isAnswered && $option === $correct,
                            // Wrong answer state
                            'border-red-500 bg-red-50' =>
                                $isAnswered && $option === $selectedOption && $option !== $correct,
                            // Unselected options after answering
                            'border-[var(--line-clr)] text-[var(--secondary-text-clr)]' =>
                                $isAnswered && $option !== $selectedOption,
                        ])>
                        <div class="flex items-center">
                            {{-- Status Icon --}}
                            <div @class([
                                'w-6 h-6 rounded-full flex items-center justify-center mr-4',
                                'text-[var(--text-clr)]' => !$isAnswered,
                                'bg-green-500 text-white p-3' => $isAnswered && $option === $correct,
                                'bg-red-500 text-white p-3' =>
                                    $isAnswered && $option === $selectedOption && $option !== $correct,
                            ])>
                                @if (!$isAnswered)
                                    <span class="material-symbols-outlined text-xl">circle</span>
                                @elseif($isAnswered && $option === $correct)
                                    <span class="material-symbols-outlined text-xl">check</span>
                                @elseif($isAnswered && $option === $selectedOption && $option !== $correct)
                                    <span class="material-symbols-outlined text-xl">close</span>
                                @endif
                            </div>

                            {{-- Option Text --}}
                            <span @class([
                                'text-lg font-medium',
                                'text-green-700' => $isAnswered && $option === $correct,
                                'text-red-700' =>
                                    $isAnswered && $option === $selectedOption && $option !== $correct,
                                'text-[var(--text-clr)]' => !(
                                    $isAnswered &&
                                    ($option === $correct ||
                                        ($option === $selectedOption && $option !== $correct))
                                ),
                            ])>
                                {{ $option }}
                                @if (env('APP_ENV') === 'local' && $option === $correct)
                                    <br><small class="text-gray-500">Correct</small>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </label>
        @endforeach
    </div>
</div>
