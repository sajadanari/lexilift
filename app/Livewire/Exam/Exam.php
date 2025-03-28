<?php

namespace App\Livewire\Exam;

use Livewire\Component;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use App\Services\OpenAIService;
use App\Enums\WordLevel;

class Exam extends Component
{
    public $isStarted = false;
    public $questions = [];
    public $userAnswers = [];
    public $currentQuestionIndex = 0;
    public $examFinished = false;
    public $score = 0;
    public $userInput = ''; // اضافه کردن متغیر
    public $currentQuestionAnswered = false;

    public function __construct()
    {

    }

    protected function getListeners()
    {
        return [
            'answer-submitted' => 'answerSubmitted',
            'next-question' => 'nextQuestion'
        ];
    }

    // شروع آزمون
    public function startExam()
    {
        $this->isStarted = true;
        $this->examFinished = false;
        $this->score = 0;
        $this->userAnswers = [];
        $this->currentQuestionIndex = 0;

        $baseQuery = Auth::user()->words();
        $selectedWordIds = [];
        $questions = collect();

        foreach ([WordLevel::WEAK, WordLevel::MEDIUM, WordLevel::STRONG] as $level) {
            $range = $level->getRange();
            $targetCount = $level->getQuestionCount();

            $words = (clone $baseQuery)->whereBetween('score', [$range['min'], $range['max']])
                ->whereNotIn('id', $selectedWordIds)
                ->inRandomOrder()
                ->limit($targetCount)
                ->get();

            if ($words->count() < $targetCount) {
                // Try to get remaining words from other levels
                $remaining = $targetCount - $words->count();
                $otherWords = (clone $baseQuery)->whereNotIn('id', array_merge($selectedWordIds, $words->pluck('id')->toArray()))
                    ->inRandomOrder()
                    ->limit($remaining)
                    ->get();

                $words = $words->merge($otherWords);
            }

            $selectedWordIds = array_merge($selectedWordIds, $words->pluck('id')->toArray());
            $questions = $questions->merge($words);
        }

        $this->questions = $questions->map(function($word) {
            return [
                'type' => 1,
                'word' => $word,
            ];
        })->toArray();
    }

    public function nextQuestion()
    {
        $this->currentQuestionAnswered = false;
        if($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        } else {
            $this->examFinished = true;
        }
    }

    public function answerSubmitted($isCorrect)
    {
        if($isCorrect) {
            $this->score++;
        }
        $this->currentQuestionAnswered = true;
    }

    public function render()
    {
        return view('livewire.exam.exam')->layout('layouts.front-app');
    }
}
