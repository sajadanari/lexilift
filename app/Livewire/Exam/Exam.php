<?php

namespace App\Livewire\Exam;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Enums\WordLevel;

/**
 * Exam Component
 *
 * Handles the vocabulary examination process including:
 * - Exam initialization and question generation
 * - Question progression management
 * - Score tracking
 * - User response handling
 */
class Exam extends Component
{
    /** @var bool Indicates if the exam has started */
    public $isStarted = false;

    /** @var array Collection of questions for the exam */
    public $questions = [];

    /** @var array Stores user's answers for each question */
    public $userAnswers = [];

    /** @var int Current question position */
    public $currentQuestionIndex = 0;

    /** @var bool Indicates if the exam is completed */
    public $examFinished = false;

    /** @var int User's current score */
    public $score = 0;

    /** @var string For storing temporary user input */
    public $userInput = '';

    /** @var bool Tracks if current question has been answered */
    public $currentQuestionAnswered = false;

    /** @var int Minimum words required to start the exam */
    public $minimumWordsRequired;

    /**
     * Define Livewire event listeners
     */
    protected function getListeners()
    {
        return [
            'answer-submitted' => 'answerSubmitted',
            'next-question' => 'nextQuestion'
        ];
    }

    /**
     * Initializes component state
     */
    public function mount()
    {
        $this->minimumWordsRequired = WordLevel::WEAK->getQuestionCount() + 
            WordLevel::MEDIUM->getQuestionCount() + 
            WordLevel::STRONG->getQuestionCount();
    }

    /**
     * Checks if the user has enough words to start the exam
     * @return bool
     */
    private function hasEnoughWords(): bool
    {
        return Auth::user()->words()->count() >= $this->minimumWordsRequired;
    }

    /**
     * Initializes and starts a new exam
     * Generates questions based on word difficulty levels:
     * - Weak words (low score)
     * - Medium words (medium score)
     * - Strong words (high score)
     */
    public function startExam()
    {
        if (!$this->hasEnoughWords()) {
            return;
        }

        // Reset exam state
        $this->isStarted = true;
        $this->examFinished = false;
        $this->score = 0;
        $this->userAnswers = [];
        $this->currentQuestionIndex = 0;

        $baseQuery = Auth::user()->words();
        $selectedWordIds = [];
        $questions = collect();

        // Generate questions for each difficulty level
        foreach ([WordLevel::WEAK, WordLevel::MEDIUM, WordLevel::STRONG] as $level) {
            $range = $level->getRange();
            $targetCount = $level->getQuestionCount();

            // Get words for current difficulty level
            $words = (clone $baseQuery)
                ->whereBetween('score', [$range['min'], $range['max']])
                ->whereNotIn('id', $selectedWordIds)
                ->inRandomOrder()
                ->limit($targetCount)
                ->get();

            // Fill up with words from other levels if needed
            if ($words->count() < $targetCount) {
                $remaining = $targetCount - $words->count();
                $otherWords = (clone $baseQuery)
                    ->whereNotIn('id', array_merge($selectedWordIds, $words->pluck('id')->toArray()))
                    ->inRandomOrder()
                    ->limit($remaining)
                    ->get();

                $words = $words->merge($otherWords);
            }

            $selectedWordIds = array_merge($selectedWordIds, $words->pluck('id')->toArray());
            $questions = $questions->merge($words);
        }

        // Format questions for the exam
        $this->questions = $questions->map(function($word) {
            return [
                'type' => rand(1, 2),
                'word' => $word,
            ];
        })->toArray();
    }

    /**
     * Advances to the next question or finishes the exam
     */
    public function nextQuestion()
    {
        $this->currentQuestionAnswered = false;
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        } else {
            $this->examFinished = true;
        }
    }

    /**
     * Handles the submission of an answer
     * @param bool $isCorrect Whether the submitted answer was correct
     */
    public function answerSubmitted($isCorrect)
    {
        if ($isCorrect) {
            $this->score++;
        }
        $this->currentQuestionAnswered = true;
    }

    public function render()
    {
        return view('livewire.exam.exam')->layout('layouts.front-app');
    }
}
