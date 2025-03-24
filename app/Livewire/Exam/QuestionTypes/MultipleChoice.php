<?php

namespace App\Livewire\Exam\QuestionTypes;

use Livewire\Component;
use App\Models\Word;

class MultipleChoice extends Component
{
    public $word;
    public $options;
    public $correct;

    public function mount($word)
    {
        $this->word = $word;
        $this->generateQuestion();
    }

    public function generateQuestion()
    {
        $this->correct = $this->word->meaning;

        // انتخاب گزینه‌های اشتباه
        $otherWords = Word::where('user_id', $this->word->user_id)
                          ->where('id', '!=', $this->word->id)
                          ->inRandomOrder()
                          ->limit(3)
                          ->get();
        $wrongOptions = $otherWords->pluck('meaning')->toArray();

        // ترکیب و شافل گزینه‌ها
        $this->options = array_merge([$this->correct], $wrongOptions);
        shuffle($this->options);
    }

    public function submitAnswer($answer)
    {
        $this->dispatch('answer-submitted', [
            'answer' => $answer
        ]);
    }

    public function render()
    {
        return view('livewire.exam.question-types.multiple-choice');
    }
}
