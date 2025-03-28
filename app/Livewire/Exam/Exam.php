<?php

namespace App\Livewire\Exam;

use Livewire\Component;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use App\Services\OpenAIService;

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

        // Get initial weak words
        $weakWords = (clone $baseQuery)
            ->where('score', '<', 40)
            ->whereNotIn('id', $selectedWordIds)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $selectedWordIds = array_merge($selectedWordIds, $weakWords->pluck('id')->toArray());

        // If we need more weak words, try getting from medium words
        if ($weakWords->count() < 6) {
            $neededCount = 6 - $weakWords->count();
            $additionalWords = (clone $baseQuery)
                ->whereBetween('score', [40, 70])
                ->whereNotIn('id', $selectedWordIds)
                ->inRandomOrder()
                ->limit($neededCount)
                ->get();

            $weakWords = $weakWords->merge($additionalWords);
            $selectedWordIds = array_merge($selectedWordIds, $additionalWords->pluck('id')->toArray());

            if ($weakWords->count() < 6) {
                $neededCount = 6 - $weakWords->count();
                $additionalWords = (clone $baseQuery)
                    ->where('score', '>', 70)
                    ->whereNotIn('id', $selectedWordIds)
                    ->inRandomOrder()
                    ->limit($neededCount)
                    ->get();

                $weakWords = $weakWords->merge($additionalWords);
                $selectedWordIds = array_merge($selectedWordIds, $additionalWords->pluck('id')->toArray());
            }
        }

        // Get medium words
        $mediumWords = (clone $baseQuery)
            ->whereBetween('score', [40, 70])
            ->whereNotIn('id', $selectedWordIds)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $selectedWordIds = array_merge($selectedWordIds, $mediumWords->pluck('id')->toArray());

        // If we need more medium words, try from good words first, then weak words
        if ($mediumWords->count() < 3) {
            $neededCount = 3 - $mediumWords->count();
            $additionalWords = (clone $baseQuery)
                ->where('score', '>', 70)
                ->whereNotIn('id', $selectedWordIds)
                ->inRandomOrder()
                ->limit($neededCount)
                ->get();

            $mediumWords = $mediumWords->merge($additionalWords);
            $selectedWordIds = array_merge($selectedWordIds, $additionalWords->pluck('id')->toArray());

            if ($mediumWords->count() < 3) {
                $neededCount = 3 - $mediumWords->count();
                $additionalWords = (clone $baseQuery)
                    ->where('score', '<', 40)
                    ->whereNotIn('id', $selectedWordIds)
                    ->inRandomOrder()
                    ->limit($neededCount)
                    ->get();

                $mediumWords = $mediumWords->merge($additionalWords);
                $selectedWordIds = array_merge($selectedWordIds, $additionalWords->pluck('id')->toArray());
            }
        }

        // Get good words
        $goodWords = (clone $baseQuery)
            ->where('score', '>', 70)
            ->whereNotIn('id', $selectedWordIds)
            ->inRandomOrder()
            ->limit(1)
            ->get();

        // If we need more good words, try from medium words first, then weak words
        if ($goodWords->count() < 1) {
            $additionalWords = (clone $baseQuery)
                ->whereBetween('score', [40, 70])
                ->whereNotIn('id', $selectedWordIds)
                ->inRandomOrder()
                ->limit(1)
                ->get();

            $goodWords = $goodWords->merge($additionalWords);

            if ($goodWords->count() < 1) {
                $additionalWords = (clone $baseQuery)
                    ->where('score', '<', 40)
                    ->whereNotIn('id', $selectedWordIds)
                    ->inRandomOrder()
                    ->limit(1)
                    ->get();

                $goodWords = $goodWords->merge($additionalWords);
            }
        }

        $selectedWords = $weakWords->merge($mediumWords)->merge($goodWords);

        // ساخت سوالات به ازای هر کلمه
        $this->questions = $selectedWords->map(function($word) {
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
