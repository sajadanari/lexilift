<div>
    @if(!$isStarted)
        <div class="text-center">
            <h2>بخش آزمون</h2>
            <button wire:click="startExam" class="btn btn-primary">شروع آزمون</button>
        </div>
    @else
        @if(!$examFinished)
            @php $question = $questions[$currentQuestionIndex]; @endphp
            <div class="question">
                <h4>سوال {{ $currentQuestionIndex + 1 }} از {{ count($questions) }}</h4>

                @if($question['type'] == 1 || $question['type'] == 3)
                    <p><strong>کلمه:</strong> {{ $question['word']->word }}</p>
                    @foreach($question['options'] as $option)
                        <label class="block">
                            <input type="radio" name="answer" wire:model="userAnswer">
                            <span wire:click="submitAnswer('{{ $option }}')">{{ $option }}</span>
                        </label>
                    @endforeach
                @elseif($question['type'] == 2)
                    <div class="fill-in-blank">
                        <p class="mb-4">{{ $question['prompt'] }}</p>
                        <div class="options">
                            @foreach($question['options'] as $option)
                                <button class="btn btn-outline-primary m-2" wire:click="submitAnswer('{{ $option }}')">
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @elseif($question['type'] == 4)
                    <p>{{ $question['prompt'] }}</p>
                    <input type="text" wire:model.defer="userInput">
                    <button wire:click="submitAnswer(userInput)">ثبت پاسخ</button>
                @endif
            </div>
        @else
            <div class="result text-center">
                <h3>آزمون به پایان رسید</h3>
                <p>امتیاز شما: {{ $score }} از {{ count($questions) }}</p>
                <button wire:click="startExam" class="btn btn-secondary">شروع مجدد</button>
            </div>
        @endif
    @endif
</div>
