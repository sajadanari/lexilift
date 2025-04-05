{{-- 
    Exam Component View
    Handles the display of:
    - Exam start screen
    - Question progression
    - Progress tracking
    - Results display
--}}

<div class="min-h-screen">
    <div class="mx-auto p-0 md:px-4 md:py-8 max-w-4xl">
        @if (!$isStarted)
            {{-- Start Screen --}}
            <div class="container">
                <div class="flex flex-col items-center justify-center space-y-8">
                    <div class="relative">
                        <span class="material-symbols-outlined text-[var(--accent-clr)] text-7xl animate-bounce">
                            school
                        </span>
                        <span class="absolute -right-2 -top-2 bg-[var(--accent-clr)] text-white rounded-full p-2 flex">
                            <span class="material-symbols-outlined text-xl">flag</span>
                        </span>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-3xl font-bold text-gray-800">
                            Ready to Test Your Knowledge?
                        </h2>
                        <p class="text-[var(--secondary-text-clr)] max-w-md mx-auto">
                            You'll be presented with 10 questions to test your vocabulary skills.
                            Take your time and choose your answers carefully.
                        </p>
                    </div>

                    <x-forms.primary-btn wire:click="startExam" class="w-full md:w-auto animate-pulse"
                        icon="play_arrow">
                        Start Exam
                    </x-forms.primary-btn>
                </div>
            </div>
        @else
            @if (!$examFinished)
                {{-- Active Exam Interface --}}
                @php $question = $questions[$currentQuestionIndex]; @endphp
                <div class="space-y-6">
                    {{-- Progress Tracking --}}
                    <div class="container">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-lg font-semibold text-[var(--text-clr)]">
                                Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}
                            </h4>
                            <div class="flex items-center text-[var(--secondary-text-clr)]">
                                <span class="material-symbols-outlined mr-2">quiz</span>
                                <span>{{ $currentQuestionIndex + 1 }}/{{ count($questions) }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-[var(--accent-clr)] h-2.5 rounded-full transition-all duration-500"
                                style="width: {{ (($currentQuestionIndex + 1) / count($questions)) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Question Display --}}
                    @if ($question['type'] == 1)
                        <livewire:exam.question-types.multiple-choice-meaning-by-word :word="$question['word']"
                            :key="$currentQuestionIndex" />
                    @endif

                    {{-- Navigation Controls --}}
                    <div class="mt-8">
                        <x-forms.primary-btn wire:click="nextQuestion" icon='arrow_forward' :isDisable='!$currentQuestionAnswered'
                            class="float-right">
                            {{ $currentQuestionIndex === count($questions) - 1 ? 'Show Results' : 'Next Question' }}
                        </x-forms.primary-btn>
                    </div>
                </div>
            @else
                {{-- Results Screen --}}
                <div class="container text-center">
                    <div class="flex flex-col items-center justify-center space-y-6">
                        <div class="relative">
                            @if ($score / count($questions) >= 0.7)
                                <span class="material-symbols-outlined text-yellow-500 text-8xl animate-bounce">
                                    emoji_events
                                </span>
                            @else
                                <span class="material-symbols-outlined text-blue-500 text-8xl">
                                    workspace_premium
                                </span>
                            @endif
                        </div>

                        <div class="space-y-4">
                            <h3 class="">Exam Completed!</h3>
                            <div class="text-4xl font-bold text-[var(--accent-clr)]">
                                {{ $score }} / {{ count($questions) }}
                                <p class="text-sm text-[var(--secondary-text-clr)] mt-1">
                                    {{ round(($score / count($questions)) * 100) }}% Accuracy
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button wire:click="startExam"
                                class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                                <span class="material-symbols-outlined">refresh</span>
                                <span>Try Again</span>
                            </button>
                            <a href="{{ route('dashboard') }}"
                                class="px-6 py-3 bg-[var(--accent-clr)] text-white rounded-xl hover:bg-[var(--accent-clr-dark)] transition-all duration-300 flex items-center space-x-2">
                                <span class="material-symbols-outlined">home</span>
                                <span>Back to Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
