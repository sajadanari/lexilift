<?php

namespace App\Livewire\Exam\QuestionTypes;

use Livewire\Component;
use App\Models\Word;

class MultipleChoice extends Component
{
    public $word;
    public $options;
    public $correct;
    public $selectedOption;
    public $isAnswered = false;

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

    // ثبت پاسخ کاربر برای سوال فعلی
    public function submitAnswer($selectedOption)
    {
        if ($this->isAnswered) {
            return;
        }

        $this->selectedOption = $selectedOption;
        $this->isAnswered = true;

        $isCorrect = $this->selectedOption === $this->correct;

        if ($isCorrect) {
            $this->word->score = $this->word->score + 5;
        } else {
            $this->word->score = max(0, $this->word->score - 3);
        }

        $this->word->save();
        $this->dispatch('answer-submitted', isCorrect: $isCorrect);
    }

    public function render()
    {
        return view('livewire.exam.question-types.multiple-choice');
    }
}
