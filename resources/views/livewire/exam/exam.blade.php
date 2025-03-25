<div class="container mx-auto px-4 py-8">
    @if(!$isStarted)
        <div class="flex flex-col items-center justify-center space-y-6">

            <span class="material-symbols-outlined text-[var(--accent-clr)] text-6xl">
                flag
            </span>

            <h2 class="text-2xl font-bold text-gray-800">
                Are you ready?
            </h2>

            <x-forms.primary-btn
                wire:click="startExam"
                class="w-full md:w-auto"
            >
                Start Exam
            </x-forms.primary-btn>

        </div>
    @else
        @if(!$examFinished)
            @php $question = $questions[$currentQuestionIndex]; @endphp
            <div class="space-y-6">
                <h4 class="text-lg font-semibold text-gray-700">Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}</h4>

                @if($question['type'] == 1)
                    <livewire:exam.question-types.multiple-choice :word="$question['word']" :key="$currentQuestionIndex" />
                @endif

                <div class="mt-4">

                    <button wire:click="nextQuestion"
                            @class([
                                'px-6 py-2 rounded-lg transition-colors w-full',
                                'bg-[var(--accent-clr)] text-white cursor-pointer' => $currentQuestionAnswered,
                                'bg-gray-300 text-gray-500 cursor-not-allowed' => !$currentQuestionAnswered
                            ])
                            {{ !$currentQuestionAnswered ? 'disabled' : '' }}>
                        {{ $currentQuestionIndex === count($questions) - 1 ? 'Show Results' : 'Next Question' }}
                    </button>

                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center space-y-4 bg-white p-8 rounded-lg shadow-sm">
                <h3 class="text-xl font-bold text-gray-800">Exam Completed</h3>
                <p class="text-gray-700">Your score: {{ $score }} out of {{ count($questions) }}</p>
                <button wire:click="startExam"
                    class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Restart Exam
                </button>
            </div>
        @endif
    @endif
</div>
