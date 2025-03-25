<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        @if(!$isStarted)
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="flex flex-col items-center justify-center space-y-8">
                    <div class="relative">
                        <span class="material-symbols-outlined text-[var(--accent-clr)] text-7xl animate-bounce">
                            school
                        </span>
                        <span class="absolute -right-2 -top-2 bg-[var(--accent-clr)] text-white rounded-full p-2">
                            <span class="material-symbols-outlined text-xl">flag</span>
                        </span>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-3xl font-bold text-gray-800">
                            Ready to Test Your Knowledge?
                        </h2>
                        <p class="text-gray-600 max-w-md mx-auto">
                            You'll be presented with {{ count($questions) }} questions to test your vocabulary skills.
                            Take your time and choose your answers carefully.
                        </p>
                    </div>

                    <x-forms.primary-btn
                        wire:click="startExam"
                        class="w-full md:w-auto px-8 py-3 text-lg font-medium animate-pulse"
                    >
                        <span class="material-symbols-outlined mr-2">play_arrow</span>
                        Start Exam
                    </x-forms.primary-btn>
                </div>
            </div>
        @else
            @if(!$examFinished)
                @php $question = $questions[$currentQuestionIndex]; @endphp
                <div class="space-y-6">
                    <!-- Progress Bar -->
                    <div class="bg-white p-4 rounded-xl shadow-sm mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-lg font-semibold text-gray-700">
                                Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}
                            </h4>
                            <div class="flex items-center text-gray-600">
                                <span class="material-symbols-outlined mr-2">timer</span>
                                <span>{{ $currentQuestionIndex + 1 }}/{{ count($questions) }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-[var(--accent-clr)] h-2.5 rounded-full transition-all duration-500"
                                 style="width: {{ ($currentQuestionIndex + 1) / count($questions) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    @if($question['type'] == 1)
                        <livewire:exam.question-types.multiple-choice :word="$question['word']" :key="$currentQuestionIndex" />
                    @endif

                    <div class="mt-8">
                        <button wire:click="nextQuestion"
                                @class([
                                    'px-6 py-3 rounded-xl transition-all duration-300 w-full md:w-auto float-right flex items-center justify-center space-x-2',
                                    'bg-[var(--accent-clr)] hover:bg-[var(--accent-clr-dark)] text-white cursor-pointer transform hover:scale-105' => $currentQuestionAnswered,
                                    'bg-gray-200 text-gray-400 cursor-not-allowed' => !$currentQuestionAnswered
                                ])
                                {{ !$currentQuestionAnswered ? 'disabled' : '' }}>
                            <span>{{ $currentQuestionIndex === count($questions) - 1 ? 'Show Results' : 'Next Question' }}</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                </div>
            @else
                <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
                    <div class="flex flex-col items-center justify-center space-y-6">
                        <div class="relative">
                            @if($score / count($questions) >= 0.7)
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
                            <h3 class="text-3xl font-bold text-gray-800">Exam Completed!</h3>
                            <div class="text-4xl font-bold text-[var(--accent-clr)]">
                                {{ $score }} / {{ count($questions) }}
                                <p class="text-sm text-gray-600 mt-1">
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
