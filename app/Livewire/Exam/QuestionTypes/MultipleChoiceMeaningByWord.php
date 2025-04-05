<?php

namespace App\Livewire\Exam\QuestionTypes;

use Livewire\Component;
use App\Models\Word;

/**
 * Multiple Choice Question Component for Word Meanings
 *
 * This component handles a multiple choice question where users need to
 * select the correct meaning of a given word. It generates options by
 * combining the correct meaning with three random wrong options from
 * other words in the user's vocabulary.
 */
class MultipleChoiceMeaningByWord extends Component
{
    /** @var Word The word being tested */
    public $word;

    /** @var array List of possible answers including the correct one */
    public $options;

    /** @var string The correct meaning of the word */
    public $correct;

    /** @var string|null The user's selected answer */
    public $selectedOption;

    /** @var bool Indicates if the question has been answered */
    public $isAnswered = false;

    /**
     * Initialize the component with a word
     *
     * @param Word $word The word to create a question for
     */
    public function mount($word)
    {
        $this->word = $word;
        $this->generateQuestion();
    }

    /**
     * Generate a new multiple choice question
     * This method:
     * 1. Sets the correct answer
     * 2. Fetches 3 random wrong options from other words
     * 3. Combines and shuffles all options
     */
    public function generateQuestion()
    {
        $this->correct = $this->word->meaning;

        // Select 3 random wrong options from other words of the same user
        $otherWords = Word::where('user_id', $this->word->user_id)
                          ->where('id', '!=', $this->word->id)
                          ->inRandomOrder()
                          ->limit(3)
                          ->get();
        $wrongOptions = $otherWords->pluck('meaning')->toArray();

        // Combine correct and wrong options, then shuffle
        $this->options = array_merge([$this->correct], $wrongOptions);
        shuffle($this->options);
    }

    /**
     * Handle the user's answer submission
     *
     * This method:
     * 1. Checks if the question hasn't been answered yet
     * 2. Records the user's selected option
     * 3. Updates the word's score based on the answer
     * 4. Dispatches an event with the result
     *
     * @param string $selectedOption The option selected by the user
     */
    public function submitAnswer($selectedOption)
    {
        // Prevent multiple submissions for the same question
        if ($this->isAnswered) {
            return;
        }

        $this->selectedOption = $selectedOption;
        $this->isAnswered = true;

        $isCorrect = $this->selectedOption === $this->correct;

        // Update word score: increase for correct answers, decrease for wrong ones
        if ($isCorrect) {
            $this->word->score = min(100, $this->word->score + config('myapp.multiple_choice_meaning_by_word.score.correct'));
        } else {
            $this->word->score = max(0, $this->word->score + config('myapp.multiple_choice_meaning_by_word.score.incorrect'));
        }

        $this->word->save();
        $this->dispatch('answer-submitted', isCorrect: $isCorrect);
    }

    /**
     * Render the component's view
     */
    public function render()
    {
        return view('livewire.exam.question-types.multiple-choice-meaning-by-word');
    }
}
