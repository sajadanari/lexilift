<div class="container mx-auto px-4 py-8">
    @if(!$isStarted)
        <div class="flex flex-col items-center justify-center space-y-4">
            <h2 class="text-2xl font-bold text-gray-800">Exam Section</h2>
            <button wire:click="startExam" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Start Exam
            </button>
        </div>
    @else
        @if(!$examFinished)
            @php $question = $questions[$currentQuestionIndex]; @endphp
            <div class="space-y-6">
                <h4 class="text-lg font-semibold text-gray-700">Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}</h4>

                @if($question['type'] == 1 || $question['type'] == 3)
                    <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                        <p class="text-gray-800"><strong>Word:</strong> {{ $question['word']->word }}</p>
                        <div class="space-y-3">
                            @foreach($question['options'] as $option)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="answer" wire:model="userAnswer" class="form-radio text-blue-600">
                                    <span wire:click="submitAnswer('{{ $option }}')" class="text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @elseif($question['type'] == 2)
                    <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                        <p class="text-gray-800 mb-4">{{ $question['prompt'] }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($question['options'] as $option)
                                <button wire:click="submitAnswer('{{ $option }}')"
                                    class="px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition-colors">
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @elseif($question['type'] == 3)
                    <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                        <p class="text-gray-800 mb-4">Match the correct meaning for: <strong>{{ $question['word']->word }}</strong></p>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                @foreach($question['meanings'] as $meaning)
                                    <button wire:click="submitAnswer('{{ $meaning }}')"
                                        class="w-full px-4 py-2 text-left border border-gray-300 rounded-md hover:bg-blue-50 transition-colors">
                                        {{ $meaning }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @elseif($question['type'] == 4)
                    <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                        <div class="space-y-3">
                            <p class="text-gray-800 font-medium">{{ $question['prompt'] }}</p>
                            <p class="text-lg text-gray-900">{{ $question['meaning'] }}</p>
                            @if($question['example'])
                                <p class="text-sm text-gray-600 italic">Example: {{ $question['example'] }}</p>
                            @endif
                            @if($question['pronunciation'])
                                <p class="text-sm text-gray-600">Pronunciation: {{ $question['pronunciation'] }}</p>
                            @endif
                        </div>
                        <form wire:submit.prevent="submitAnswer" class="flex space-x-2 mt-4">
                            <input type="text"
                                wire:model.defer="userInput"
                                class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Type the word here...">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Submit
                            </button>
                        </form>
                    </div>
                @endif
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
